<?php

class nc_csv
{

    protected static $instance;
    protected $subdivision_list = array();
    protected $default_fields = array('Keyword', 'ncTitle', 'ncKeywords', 'ncDescription');

    private function __construct()
    {
        
    }

    private function __clone()
    {
        
    }

    private function __wakeup()
    {
        
    }

    public static function get_instance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function get_allowed_field_types()
    {
        return array(
          NC_FIELDTYPE_STRING,
          NC_FIELDTYPE_INT,
          NC_FIELDTYPE_TEXT,
          NC_FIELDTYPE_BOOLEAN,
          NC_FIELDTYPE_FLOAT,
          NC_FIELDTYPE_FILE,
          NC_FIELDTYPE_DATETIME
        );
    }

    public function get_subclass_type_export_form($id = '')
    {
        $options = array('' => TOOLS_CSV_NOT_SELECTED);

        $result = nc_db_table::make('Catalogue')
          ->select('Catalogue_ID, Catalogue_Name, Domain')
          ->order_by('Priority')
          ->order_by('Catalogue_Name')
          ->order_by('Catalogue_ID')
          ->limit(null)
          ->index_by_id()
          ->as_object()
          ->get_result()
        ;

        foreach ($result as $site_id => $row) {
            $options[$site_id] = $site_id . '. ' . $row->Catalogue_Name . ' (' . $row->Domain . ')';
        }

        return nc_core()->ui->form->add_row(TOOLS_CSV_SELECT_SITE)->select('data[site_id]', $options)->attr('id', 'site_id');
    }
    
    public function get_component_type_export_form($id = '')
    {
        $options = array('' => TOOLS_CSV_NOT_SELECTED);

        $result = nc_db_table::make('Class')
            ->select('Class_ID, Class_Name, Class_Group, File_Mode')
            ->where('System_Table_ID', 0)->where('ClassTemplate', 0)
            ->order_by('File_Mode', 'DESC')->order_by('Class_Group')->order_by('Class_Name')->limit(null)
            ->as_object()->get_result();

        foreach ($result as $row) {
            $group = $row->Class_Group . ($row->File_Mode ? '' : ' (v4)');
            $options[$group][$row->Class_ID] = $row->Class_ID . '. ' . $row->Class_Name;
        }
        $ret = nc_core()->ui->form->add_row(TOOLS_CSV_SELECT_COMPONENT)->select('data[component_id]', $options)->attr('id', 'component_id');
        $ret .= $this->get_csv_settings_form();
        return $ret;
    }

    /**
     * 
     * @param int $id
     * @return string
     */
    public function get_subdivision_export_form($id = '')
    {
        $options = array('' => TOOLS_CSV_NOT_SELECTED) + $this->get_subdivisions($id);

        $ret = '<div class="nc-form-row"><label>' . TOOLS_CSV_SELECT_SUBDIVISION . '</label>';
        $ret .= '<select name="data[subdivision_id]" id="subdivision_id">';
        foreach ($options as $key => $value) {
            $ret .= '<option value="' . $key . '">';
            $ret .= str_replace("[space]", "&nbsp;", htmlspecialchars($value));
            $ret .= '</option>';
        }
        $ret .= '</select></div>';
        return $ret;
    }

    public function get_component_export_form($id = '')
    {

        $options = $this->get_subclasses($id);
        if (count($options) > 0) {
            $ret = nc_core()->ui->form->add_row(TOOLS_CSV_SELECT_SUBCLASS)
                ->select('data[subclass_id]', $options)->attr('id', 'subclass_id');
            $ret .= $this->get_csv_settings_form();
            return $ret;
        } else {
            return nc_core()->ui->alert->error(TOOLS_CSV_SUBCLASSES_NOT_FOUND);
        }
    }

    public function get_import_component_export_form($id = '')
    {

        $options = $this->get_subclasses($id);
        if (count($options) > 0) {
            $ret = nc_core()->ui->form->add_row(TOOLS_CSV_SELECT_SUBCLASS)
                ->select('data[subclass_id]', $options)->attr('id', 'subclass_id');
            return $ret;
        } else {
            return nc_core()->ui->alert->error(TOOLS_CSV_SUBCLASSES_NOT_FOUND);
        }
    }

    public function export_subclass_type($data)
    {
        $classId = $this->get_class_id($data['subclass_id']); 

        $data['csv']['terminated'] = PHP_EOL;

        $fields = array();

        $result = nc_core()->db->get_results("SELECT Field_Name FROM Field "
          . "WHERE Class_ID=" . intval($classId) . " AND TypeOfData_ID IN (" . implode(",", $this->get_allowed_field_types()) . ")", ARRAY_N);
        foreach ($result as $Array) {
            $fields[] = $Array[0];
        }

        $result = nc_core()->db->get_results("SELECT " . implode(",", (array_merge($fields, $this->default_fields))) . " "
          . "FROM Message" . $classId . " "
          . "WHERE Subdivision_ID='" . $data['subdivision_id'] . "' AND Sub_Class_ID='" . $data['subclass_id'] . "' ", ARRAY_N);


        return $this->save_to_file($this->csv_encode_header(array_merge($fields, $this->default_fields), $data['csv']) . $this->csv_encode_data($result, $data['csv']), 'export-' . date('YmdHis') . '.csv');
    }
    
    public function export_component_type($data)
    {
        $classId = $data['component_id']; 

        $data['csv']['terminated'] = PHP_EOL;

        $fields = array();

        $result = nc_core()->db->get_results("SELECT Field_Name FROM Field "
          . "WHERE Class_ID=" . intval($classId) . " AND TypeOfData_ID IN (" . implode(",", $this->get_allowed_field_types()) . ")", ARRAY_N);
        foreach ($result as $Array) {
            $fields[] = $Array[0];
        }

        $result = nc_core()->db->get_results("SELECT " . implode(",", (array_merge($fields, $this->default_fields))) . " "
          . "FROM Message" . $classId, ARRAY_N);

        return $this->save_to_file($this->csv_encode_header(array_merge($fields, $this->default_fields), $data['csv']) . $this->csv_encode_data($result, $data['csv']), 'export-' . date('YmdHis') . '.csv');
    }

    public function preimport_file($file, $data)
    {
        if (!$file) {
            throw new Exception(TOOLS_CSV_IMPORT_FILE_NOT_FOUND, 1);
        }

        if (!is_dir($file)) {
            $tmp_file = nc_core()->TMP_FOLDER . uniqid() . '.csv';
            copy($file, $tmp_file);
        }

        if (!file_exists($tmp_file)) {
            throw new Exception(TOOLS_CSV_IMPORT_FILE_NOT_FOUND . " " . $tmp_file, 1);
        }

        $head_fields = $this->process_csv_header($tmp_file, $data['csv']);

        $classId = $this->get_class_id($data['subclass_id']); 

        $fields = array();
        $result = nc_core()->db->get_results("SELECT Field_Name, Description FROM Field "
          . "WHERE Class_ID=" . intval($classId) . " AND TypeOfData_ID IN (" . implode(",", $this->get_allowed_field_types()) . ")", ARRAY_N);
        foreach ($result as $Array) {
            $fields[$Array[0]] = $Array[1];
        }
        $fields = $fields + array_combine($this->default_fields, $this->default_fields);
        return array(
          'site_id' => $data['site_id'], 'subdivision_id' => $data['subdivision_id'], 'subclass_id' => $data['subclass_id'],
          'csv_head' => array('' => TOOLS_CSV_NOT_SELECTED) + array_combine($head_fields, $head_fields),
          'fields' => $fields,
          'csv_settings' => $data['csv'],
          'file' => $tmp_file);
    }

    public function import_file($file, $data)
    {
        if (!$file) {
            throw new Exception(TOOLS_CSV_IMPORT_FILE_NOT_FOUND, 1);
        }
        if (!file_exists($file)) {
            throw new Exception(TOOLS_CSV_IMPORT_FILE_NOT_FOUND . " " . $file, 1);
        }

                
        $csv_data_fields = $this->process_csv($file, $data['csv']);
        
        unlink($file);
        
        $fields = array();
        foreach ($data['fields'] as $fieldName => $csvFieldKey) {
            if ($csvFieldKey != "") {
                $fields[$fieldName] = $csvFieldKey;
            }
        }
        
        global $AUTH_USER_ID, $HTTP_USER_AGENT;
        $defaultFields = array(
          'User_ID' => $AUTH_USER_ID,
          'Subdivision_ID' => $data['subdivision_id'],
          'Sub_Class_ID' => $data['subclass_id'],
          'Created' => date("Y-m-d H:i:s"),
          'LastUpdated' => date("Y-m-d H:i:s"),
          'UserAgent' => $HTTP_USER_AGENT,
          'LastUserAgent' => $HTTP_USER_AGENT,
          'IP' => getenv("REMOTE_ADDR"),
          'LastIP' => getenv("REMOTE_ADDR"),
        );
        $classId = $this->get_class_id($data['subclass_id']);
        $priority = $this->get_max_priority($classId);
        
        $values = array();
        foreach ($csv_data_fields as $csvValues) {
            $tmp = array();
            foreach ($fields as $csvKey) {
                array_push($tmp, "'".nc_core()->db->escape($csvValues[$csvKey])."'");
            }
            foreach ($defaultFields as $field) {
                array_push($tmp, "'".nc_core()->db->escape($field)."'");
            }
            $priority++;
            array_push($tmp, $priority);
            array_push($values, $tmp);
        }
        

        $i = 0; $historied = false; $history_id = 0;
        foreach ($values as $valuesArr) {
            nc_core()->db->query("INSERT INTO Message{$classId} (" . implode(",", array_merge(array_keys($fields),array_keys($defaultFields))) . ", Priority) VALUES (".  implode(",", $valuesArr).")");
            if (nc_core()->db->insert_id > 0) {
                $message_id = nc_core()->db->insert_id;
                $i++;
                if ($historied == false) {
                    nc_core()->db->query("INSERT INTO Csv_Import_History (Class_ID, Created) VALUES "
                  . "('".$classId."',  NOW())");
                    $history_id = nc_core()->db->insert_id;
                    $historied = true;
                }
                nc_core()->db->query("INSERT INTO Csv_Import_History_Ids (History_ID, Message_ID) VALUES "
                  . "('".$history_id."', '".$message_id."')");
            }
        }
        
        return array('success' => $i);
        
    }

    public function get_csv_settings_form()
    {
        return nc_core()->ui->form->add_row(TOOLS_CSV_SELECT_SETTINGS) .
          nc_core()->ui->form->add_row(TOOLS_CSV_OPT_CHARSET)->select('data[csv][charset]', array('utf8' => TOOLS_CSV_OPT_CHARSET_UTF8, 'cp1251' => TOOLS_CSV_OPT_CHARSET_CP1251)) .
          nc_core()->ui->form->add_row(TOOLS_CSV_OPT_SEPARATOR)->string('data[csv][separator]', ";") .
          nc_core()->ui->form->add_row(TOOLS_CSV_OPT_ENCLOSED)->string('data[csv][enclosed]', "\"") .
          nc_core()->ui->form->add_row(TOOLS_CSV_OPT_ESCAPED)->string('data[csv][escaped]', "\"") .
          nc_core()->ui->form->add_row(TOOLS_CSV_OPT_NULL)->string('data[csv][null]', "NULL");
    }
    
    public function history_list()
    {
        $list = array();

        $result = nc_core()->db->get_results("SELECT cih.History_ID, cih.Created, "
          . "c.Class_Name, COUNT(cihi.History_ID), cih.Rollbacked "
          . "FROM Csv_Import_History AS cih "
          . "LEFT JOIN Class AS c ON c.Class_ID = cih.Class_ID "
          . "LEFT JOIN Csv_Import_History_Ids AS cihi ON cihi.History_ID = cih.History_ID "
          . "GROUP BY cih.History_ID "
          . "ORDER BY cih.History_ID DESC", ARRAY_N);
        foreach ((array)$result as $Array) {
            $list[$Array[0]] = array('Created' => date('d-m-Y H:i', strtotime($Array[1])),'Class_Name' => $Array[2], 'Rows' => $Array[3], 'Rollbacked' => $Array[4]);
        }
        return $list;
    }

    public function rollback($id=0)
    {
        $result = nc_core()->db->get_results("SELECT cihi.Message_ID, cih.Class_ID "
          . "FROM Csv_Import_History AS cih "
          . "LEFT JOIN Csv_Import_History_Ids AS cihi ON cihi.History_ID = cih.History_ID "
          . "WHERE cih.History_ID='".intval($id)."' AND cih.Rollbacked='0' ", ARRAY_N);
        $remove = array();
        foreach ($result as $Array) {
            array_push($remove, $Array[0]);
        }
        if (count($remove) > 0) 
        {
            nc_core()->db->query("DELETE FROM Message{$result[0][1]} WHERE Message_ID IN (".  implode(",", $remove).")");
            nc_core()->db->query("UPDATE Csv_Import_History SET Rollbacked=1 WHERE History_ID='".intval($id)."'");
        }
        return array('rollbacked' => count($remove));
        
    }
    /**
     * 
     * @param int $CatalogueID
     * @return type
     */
    protected function get_subdivisions($CatalogueID = 0)
    {
        $this->subdivision_list = array();
        $this->get_subdivisions_tree(0, $CatalogueID);

        return $this->subdivision_list;
    }

    /**
     * 
     * @global type $perm
     * @param int $ParentSubID
     * @param int $CatalogueID
     * @param int $count
     */
    protected function get_subdivisions_tree($ParentSubID, $CatalogueID, $count = 1)
    {
        global $perm;

        $CatalogueID = intval($CatalogueID);
        $ParentSubID = intval($ParentSubID);

        $security_limit = "";

        if (empty($initialized)) {
            $initialized = true;
            $allow_id = $perm->GetAllowSub($CatalogueID, MASK_ADMIN | MASK_MODERATE);
            $security_limit = is_array($allow_id) && !$perm->isGuest() ? " Subdivision_ID IN (" . join(', ', (array) $allow_id) . ")" : " 1";
        }

        $Result = nc_core()->db->get_results("SELECT a.Subdivision_ID,a.Subdivision_Name FROM Subdivision AS a, Catalogue AS b
    WHERE a.Catalogue_ID=b.Catalogue_ID AND a.Catalogue_ID=" . $CatalogueID . "
    AND a.Parent_Sub_ID='" . $ParentSubID . "' AND " . $security_limit . " ORDER BY a.Priority", ARRAY_N);

        if (!empty($Result)) {
            foreach ($Result as $Array) {
                $this->subdivision_list[$Array[0]] = str_repeat('[space]→[space]', $count) . $Array[1];
                $this->get_subdivisions_tree($Array[0], $CatalogueID, $count + 1);
            }
        }
    }

    protected function get_subclasses($Subdivision_ID = 0)
    {
        $ret = array();
        $Select = "SELECT a.Sub_Class_ID, a.Sub_Class_Name
                   FROM (Sub_Class AS a,
                        Class AS b)
                     LEFT JOIN Subdivision AS c ON a.Subdivision_ID = c.Subdivision_ID
                     LEFT JOIN Catalogue AS d ON c.Catalogue_ID = d.Catalogue_ID
                       WHERE a.Subdivision_ID = " . intval($Subdivision_ID) . "
                         AND a.Class_ID = b.Class_ID
                         AND b.`ClassTemplate` = 0
                           ORDER BY a.Priority";

        $Result = nc_core()->db->get_results($Select, ARRAY_N);

        if (nc_core()->db->num_rows > 0) {
            foreach ($Result as $Array) {
                $ret[$Array[0]] = $Array[1];
            }
        }
        return $ret;
    }

    protected function csv_encode_header($fields, $settings)
    {
        $charset = $settings['charset'];
        $ret = "";
        end($fields);
        $lastElementFields = key($fields);
        foreach ($fields as $k => $title) {
            if ($charset =='cp1251') {
                $title = nc_Core::get_object()->utf8->utf2win($title);
            }
            if ($settings['enclosed'] == '') {
                $ret .= stripslashes($title);
            } else {
                $ret .= $settings['enclosed']
                  . str_replace(
                    $settings['enclosed'], $settings['escaped'] . $settings['enclosed'], stripslashes($title)
                  )
                  . $settings['enclosed'];
            }

            if ($k != $lastElementFields) {
                $ret .= $settings['separator'];
            }
        }
        $ret .= $settings['terminated'];
        return $ret;
    }

    protected function csv_encode_data($rows, $settings)
    {
        $charset = $settings['charset'];
        $ret = "";
        end($rows);
        $lastElementRows = key($rows);

        foreach ($rows as $k => $fields) {
            end($fields);
            $lastElementFields = key($fields);
            foreach ($fields as $j => $value) {
                if (!isset($value) || is_null($value)) {
                    $ret .= $settings['null'];
                } else {
                    $value = str_replace("\n", "", str_replace("\r", "", $value));
                    if ($charset =='cp1251') {
                        $value = nc_Core::get_object()->utf8->utf2win($value);
                    }
                    if ($settings['enclosed'] == '') {
                        $ret .= $value;
                    } else {
                        // also double the escape string if found in the data
                        if ($settings['escaped'] != $settings['enclosed']) {
                            $ret .= $settings['enclosed']
                              . str_replace(
                                $settings['enclosed'], $settings['escaped'] . $settings['enclosed'], str_replace(
                                  $settings['escaped'], $settings['escaped'] . $settings['escaped'], $value
                                )
                              )
                              . $settings['enclosed'];
                        } else {
                            $ret .= $settings['enclosed']
                              . str_replace(
                                $settings['enclosed'], $settings['escaped'] . $settings['enclosed'], $value
                              )
                              . $settings['enclosed'];
                        }
                    }
                }
                if ($j != $lastElementFields) {
                    $ret .= $settings['separator'];
                }
            }
            if ($k != $lastElementRows) {
                $ret .= $settings['terminated'];
            }
        }
        return $ret;
    }

    protected function save_to_file($content, $file_name)
    {
        $export_dir = nc_core()->backup->get_export_path();

        $folder = "csv";
        $path = $export_dir . "/" . $folder;

        if (!file_exists($path)) {
            if (!file_exists($export_dir)) {
                mkdir($export_dir);
            }
            mkdir($path);
        }

        $fp = fopen($path . "/" . $file_name, "w+");

//        if (nc_core()->NC_UNICODE || empty(nc_core()->NC_CHARSET)) {
//            fwrite($fp, "\xEF\xBB\xBF");
//        }
        fwrite($fp, $content);
        fclose($fp);
        return array($file_name, nc_core()->backup()->get_export_http_path() . $folder . "/" . $file_name, nc_core()->ADMIN_PATH."/#tools.csv.delete(".urlencode($file_name).")");
    }

    protected function process_csv_header($file, $settings)
    {
        $max_line_length = defined('MAX_LINE_LENGTH') ? MAX_LINE_LENGTH : 10000;

        $fp = fopen($file, 'r+');
        $data = fgetcsv($fp, $max_line_length, $settings['separator'], $settings['enclosed']);
        if ($settings['charset'] == 'cp1251') {
            foreach($data as $key => $value) {
                $data[$key] = nc_Core::get_object()->utf8->win2utf($value);
            }
        }
        fclose($fp);
        return $data;
    }

    protected function process_csv($file, $settings)
    {
        $max_line_length = defined('MAX_LINE_LENGTH') ? MAX_LINE_LENGTH : 10000;
        foreach($settings as $key => $value) {
            $settings[$key] = stripcslashes($value);
        }

        $charset = $settings['charset'];

        $rowcount = 0; $csv = array();
        $fp = fopen($file, 'r+');
        $header = fgetcsv($fp, $max_line_length, $settings['separator'], $settings['enclosed']);
        if ($charset == 'cp1251') {
            foreach($header as $key => $value) {
                $header[$key] = nc_Core::get_object()->utf8->win2utf($value);
            }
        }
        $header_colcount = count($header);
        while (($row = fgetcsv($fp, $max_line_length, $settings['separator'], $settings['enclosed'])) !== false) {
            if ($charset == 'cp1251') {
                foreach($row as $key => $value) {
                    $row[$key] = nc_Core::get_object()->utf8->win2utf($value);
                }
            }
            $row_colcount = count($row);
            if ($row_colcount == $header_colcount) {
                foreach ($row as $k => $value) {
                    $row[$k] = str_replace($settings['escaped'].$settings['escaped'], $settings['escaped'], $value);
                }
                $entry = array_combine($header, $row);
                $csv[] = $entry;
            } else {
                error_log("csvreader: Invalid number of columns at line " . ($rowcount + 2) . " (row " . ($rowcount + 1) . "). Expected=$header_colcount Got=$row_colcount");
                return null;
            }
            $rowcount++;
        }

        fclose($fp);
        return $csv;
    }
    
    protected function get_class_id($sub_class_id=0) 
    {
        return nc_core()->db->get_var("SELECT Class_ID FROM Sub_Class WHERE Sub_Class_ID='" . intval($sub_class_id) . "' ");
    }
    
    protected function get_max_priority($class_id=0) 
    {
        return nc_core()->db->get_var("SELECT MAX(Priority) FROM Message".$class_id." ");
    }
}
