<?php
class SHMVC_Model {

    protected $connection;
    protected $variables = array();
    protected $tablename;
    protected $tableid='id';
    protected $copyfield;
    protected $infovars = array(); // Bilgi amaçlı tutulan değişkenler
    protected $dbchangelog = FALSE; // Db log tutulacak mı
    protected $dbchangelogfile = "dbchangelog.log"; // Database log dosyası
    protected $addtlog; // Db loga eklenmek istenen değer, kullanıcı bilgileri vs.
    protected $dbengine = "MYISAM";
    protected $defaultcharset = "utf8";
    protected $class_type;
    protected $field_names = array();

//-----------------------------------------------------------------------------------------------------------------------------------
    function __construct($table_name, $table_id = NULL,$connection=NULL) {
        
		if(!$connection){
			$this->connection=SHMVC_Db::get_connection();
		} else {
			$this->connection=$connection;
		}
		
		$this->tablename = $table_name;
		if($table_id){
			$this->tableid=$table_id;
		}
		
		$this->addtlog=$log_add_bilgi_tumu; // TODO:Bu kısım kontrol edilecek

		if (get_class($this) == "SHMVC_Model") { // Extends classlar ile oluşturulmamış ise >>>
            $this->class_type = 0; // Extends class değil
        } else { // <<< Extends classlar ile oluşturulmamış ise sonu
            $this->class_type = 1; // Extends class ile oluşturulmuş
            foreach ($this->table_fields as $field) {
                $this->field_names[] = $field['name'];
            }
        }
    }

// construction function bitişi
	
	
//-----------------------------------------------------------------------------------------------------------------------------------
    public function __set($name, $value) { // Ön tanımlı olmayan değişken tamınlandığında
        if ($this->class_type == 0 or in_array($name, $this->field_names)) { // Extend class ise veya alan adı tanımlı ise
            $this->variables[$name] = $value;
        } else {
            $this->error_report("Class dosyası içinde tanımlanmamış değişkene değer atanamaz...! $name");
        }
    }
//-----------------------------------------------------------------------------------------------------------------------------------
    public function __get($name) { // Ön tanımlı olmayan değişken çağrıldığında
        if ($this->class_type == 0 or in_array($name, $this->field_names)) { // Extend class ise veya alan adı tanımlı ise
            return $this->variables[$name];
        } else {
            $this->error_report("Class dosyası içinde tanımlanmamış değişkene ulaşılamaz...! $name");
        }
    }
//-----------------------------------------------------------------------------------------------------------------------------------
    public function get($id = 0, $fields = "*") {
        if ($id > 0) {
            $getrowid = intval($id);
        } else {
            $getrowid = $this->{$this->tableid};
        }
		
		if(intval($getrowid==0)){
			$this->infovars['lasterror']="Fonksiyon Get(Id) : Id değeri belirtilmedi yada, bir değişken kullanıyorsanız kaynaktan boş bir değer alıyorsunuz ! SQL sorgusu çalıştırılmadı !";
			return false;
		}
		
        $sql = "SELECT " . $fields . " FROM " . $this->tablename . " WHERE " . $this->tableid . "=" . $getrowid . " LIMIT 1";
        $sql_query = mysqli_query($this->connection, $sql);
		$this->infovars['lastquery'] = $sql;
        $this->infovars['last_mysqli_error'] = mysqli_error($this->connection);		
        if (mysqli_num_rows($sql_query) > 0) {
            $result_array = mysqli_fetch_array($sql_query, MYSQLI_ASSOC);
            $this->variables = $result_array;
            return $result_array;
        } else {

            $this->clear_public_vars();
            return false;
        }
    }
//-----------------------------------------------------------------------------------------------------------------------------------
    public function get_one($fields = "*", $where = "", $ordernsort="") {
		//$this->clear_public_vars();
		if($ordernsort!=""){
			$ordernsort=" ORDER BY ".$ordernsort;
		}
		if($where!=""){
			$where=" WHERE ".$where;
		}		
        $sql = "SELECT " . $fields . " FROM " . $this->tablename . $where . $ordernsort. " LIMIT 1";
        $sql_query = mysqli_query($this->connection, $sql);
        $this->infovars['lastquery'] = $sql;		
        if (mysqli_num_rows($sql_query) > 0) {
            $result_array = mysqli_fetch_array($sql_query, MYSQLI_ASSOC);
            $this->variables = $result_array;
            return $result_array;
        } else {
            $this->infovars['last_mysqli_error'] = mysqli_error($this->connection);
            $this->clear_public_vars();
			return false;
        }
    }

//-----------------------------------------------------------------------------------------------------------------------------------
    public function get_list($fields = "*", $where = "", $ordernsort = "", $limit = "") {// İstenen parametrelerde kayıtları listeleme
        if ($where != "") {
            $where = " WHERE " . $where;
        }
        if ($ordernsort != "") {
            $ordernsort = " ORDER BY " . $ordernsort;
        }
        if ($limit != "") {
            $limit = " LIMIT " . $limit;
        }
        $sql = "SELECT " . $fields . " FROM " . $this->tablename . $where . $ordernsort . $limit;
        $this->infovars['lastquery'] = $sql;
        $sql_result = mysqli_query($this->connection, $sql);
        $this->infovars['last_mysqli_error'] = mysqli_error($this->connection);
        if (mysqli_num_rows($sql_result) > 0) {
            while ($row = mysqli_fetch_object($sql_result)) {
                $result_array[] = $row;
            }
            mysqli_free_result($sql_result);
            return $result_array;
        } else {
            return Array();
        }
    }

//-----------------------------------------------------------------------------------------------------------------------------------
    public function get_custom_list($selectsql = "", $where = "", $ordernsort = "", $limit = "") {// Farklı tablolar dahil, istenen parametrelerde kayıtları listeleme
        if ($where != "") {
            $where = " WHERE " . $where;
        }
        if ($ordernsort != "") {
            $ordernsort = " ORDER BY " . $ordernsort;
        }
        if ($limit != "") {
            $limit = " LIMIT " . $limit;
        }
        $sql = $selectsql . $where . $ordernsort . $limit;
        $this->infovars['lastquery'] = $sql;
        $sql_result = mysqli_query($this->connection, $sql);
        $this->infovars['last_mysqli_error'] = mysqli_error($this->connection);		
        if (mysqli_num_rows($sql_result) > 0) {
            while ($row = mysqli_fetch_object($sql_result)) {
                $result_array[] = $row;
            }
            mysqli_free_result($sql_result);
            return $result_array;
        } else {
            return Array();
        }
    }

//-----------------------------------------------------------------------------------------------------------------------------------
    public function get_num_rows($fields = "*", $where = "", $ordernsort = "", $limit = "") { // İstenen parametrelerdeki kayıt listesi sayısını verir
        if ($where != "") {
            $where = " WHERE " . $where;
        }
        if ($ordernsort != "") {
            $ordernsort = " ORDER BY " . $ordernsort;
        }
        if ($limit != "") {
            $limit = " LIMIT " . $limit;
        }
        $sql = "SELECT " . $fields . " FROM " . $this->tablename . $where . $ordernsort . $limit;
        $this->infovars['lastquery'] = $sql;
        $sql_result = mysqli_query($this->connection, $sql);
        $this->infovars['last_mysqli_error'] = mysqli_error($this->connection);
		
        if (mysqli_num_rows($sql_result) > 0) {
            return mysqli_num_rows($sql_result);
			mysqli_free_result($sql_result);
        } else {
            return false;
        }
    }

//-----------------------------------------------------------------------------------------------------------------------------------

    public function get_custom_num_rows($selectsql = "", $where = "", $ordernsort = "", $limit = "") {// Farklı tablolar dahil, istenen parametrelerdeki sorgunun kayıt sayısını verir
        if ($where != "") {
            $where = " WHERE " . $where;
        }
        if ($ordernsort != "") {
            $ordernsort = " ORDER BY " . $ordernsort;
        }
        if ($limit != "") {
            $limit = " LIMIT " . $limit;
        }
        $sql = $selectsql . $where . $ordernsort . $limit;
        $this->infovars['lastquery'] = $sql;
        $sql_result = mysqli_query($this->connection, $sql);
        $this->infovars['last_mysqli_error'] = mysqli_error($this->connection);		
        if (mysqli_num_rows($sql_result) > 0) {
            return mysqli_num_rows($sql_result);
			mysqli_free_result($sql_result);
        } else {
            return false;
        }
    }

//-----------------------------------------------------------------------------------------------------------------------------------

    public function delete($id = "") {
        if ($id > 0) {
            $deleterowid = intval($id);
        } else {
            $deleterowid = $this->{$this->tableid};
        }
        $sql = "DELETE FROM " . $this->tablename . " WHERE " . $this->tableid . "=" . $deleterowid;
        $this->infovars['lastquery'] = $sql;
        if ($sql_result = mysqli_query($this->connection, $sql)) {
            if ($this->dbchangelog) {
                $this->save_to_db_log($sql, "Delete({$deleterowid})");
            }
            return TRUE;
        } else {
            $this->infovars['last_mysqli_error'] = mysqli_error($this->connection);
            return FALSE;
        }
    }

//-----------------------------------------------------------------------------------------------------------------------------------
    public function delete_list($where) {
        $sql = "DELETE FROM " . $this->tablename . " WHERE " . $where;
        $this->infovars['lastquery'] = $sql;
        if ($sql_result = mysqli_query($this->connection, $sql)) {
            if ($this->dbchangelog) {
                $this->save_to_db_log($sql, "DeleteList");
            }
            return mysqli_affected_rows($this->connection);
        } else {
            $this->infovars['last_mysqli_error'] = mysqli_error($this->connection);
            return FALSE;
        }
    }

//-----------------------------------------------------------------------------------------------------------------------------------
    public function save($id = 0) { // Yeni Kayıt - Id değeri sadece el ile verilebilir
        foreach ($this->variables as $key => $value) {
            if ($key != $this->tableid) { // Id alanı atlanıyor
                $fields.="`" . $key . "`,";
                $values.="'" . $this->escape($value) . "',";
            }
        }

        if ($id > 0) {
            $fields = "`" . $this->tableid . "`," . $fields;
            $values = "'" . intval($id) . "'," . $values;
        }

        $fields = rtrim($fields, ",");
        $values = rtrim($values, ",");
        $sql = "INSERT INTO " . $this->tablename . " (" . $fields . ") VALUES (" . $values . ")";
        $this->infovars['lastquery'] = $sql;
        if (mysqli_query($this->connection, $sql)) {
            $this->infovars['insertid'] = mysqli_insert_id($this->connection);
            if ($this->dbchangelog) {
                $this->save_to_db_log($sql, "Save");
            }
            return mysqli_insert_id($this->connection);
        } else {
            $this->infovars['last_mysqli_error'] = mysqli_error($this->connection);
            return FALSE;
        }
    }

//-----------------------------------------------------------------------------------------------------------------------------------
    public function update($id = 0) { // Var olan kaydın bilgilerini güncelleme id si bilinmek zorunda fonksiyonla yada variables içinde
        if ($id > 0) { // Fonksiyonla beraber Update edilecek kayıt id'si verilmişse variablesteki id değeri yerine bu kullanılıyor
            $updaterowid = intval($id);
        } else {
            $updaterowid = $this->{$this->tableid};
        }

        if (!$updaterowid) {
            $this->error_report("Güncellenecek kaydın id değeri belirtilmek zorunda ! ");
            return FALSE;
        }

        foreach ($this->variables as $key => $value) {
            if ($key !== $this->tableid) {
                $fieldsnvalues.="`" . $key . "`='" . $this->escape($value) . "',";
            }
        }

        $fieldsnvalues = rtrim($fieldsnvalues, ",");
        $sql = "UPDATE " . $this->tablename . " SET " . $fieldsnvalues . " WHERE " . $this->tableid . "=" . $updaterowid;
        $this->infovars['lastquery'] = $sql;

        mysqli_query($this->connection, $sql);
        if (mysqli_affected_rows($this->connection) > 0 and $this->dbchangelog) {
            $this->save_to_db_log($sql,"Update({$updaterowid})");
        }
        return mysqli_affected_rows($this->connection);
    }

//-----------------------------------------------------------------------------------------------------------------------------------

    public function update_list($fieldnamesnvalues=Array(),$where="") { // Birden fazla kaydı update etmek için $fieldnamesnvalues array değişkeni key=>value şeklinde değer alıyor
		
		if($where!=""){
			$where=" WHERE ".$where;
		}
		
        if (sizeof($fieldnamesnvalues)>0) {
			foreach($fieldnamesnvalues as $fieldname=>$fieldvalue){
				$fieldsnvalues.="`" . $fieldname . "`='" . $this->escape($fieldvalue) . "',";
			}
        } else {
            $this->error_report("Güncellenecek kayıt alanları belirtilmedi ! ");
            return FALSE;
		}

        $fieldsnvalues = rtrim($fieldsnvalues, ",");
        $sql = "UPDATE " . $this->tablename . " SET " . $fieldsnvalues . $where;
        $this->infovars['lastquery'] = $sql;
		
        mysqli_query($this->connection, $sql);
        if (mysqli_affected_rows($this->connection) > 0 and $this->dbchangelog) {
            $this->save_to_db_log($sql,"Update({$updaterowid})");
        }
        return mysqli_affected_rows($this->connection);

    }

//-----------------------------------------------------------------------------------------------------------------------------------


    public function copy_row($id = 0, $degisenler=Array()) { // Kayıt Kopyalama - Id değeri el ile verilebilir -- $degisenler arrayı içinde kopyalama sırasında değiştirilmek istenen alan ve değerler bulunabilir
        if ($id > 0) {
            $getrowid = intval($id);
        } else {
            $getrowid = $this->{$this->tableid};
        }

        if (!$getrowid) {
            $this->error_report("Kopyalanacak kaydın id değeri belirtilmek zorunda !");
            return FALSE;
        }

        if ($copythis = $this->Get($getrowid)) {
			
			if(sizeof($degisenler)>0){
				foreach($degisenler as $dkey => $dvalue){
					if(array_key_exists ( $dkey , $copythis )){
						$copythis[$dkey]=$dvalue;
					}
				}
			}
			
			
            foreach ($copythis as $key => $value) {
                if ($key != $this->tableid) {
                    $fields.="`" . $key . "`,";
                    if ($key == $this->copyfield) {
                        $value = "Kopya - " . $value;
                    }
                    $values.="'" . $this->escape($value) . "',";
                }
            }
            $fields = rtrim($fields, ",");
            $values = rtrim($values, ",");
            $sql = "INSERT INTO " . $this->tablename . " (" . $fields . ") VALUES (" . $values . ")";
            $this->infovars['lastquery'] = $sql;

            if (mysqli_query($this->connection, $sql)) {
                $this->infovars['insertid'] = mysqli_insert_id($this->connection);
                if ($this->dbchangelog) {
                    $this->save_to_db_log($sql, "Copy({$getrowid})");
                }
                return mysqli_insert_id($this->connection);
            } else {
                $this->infovars['last_mysqli_error'] = mysqli_error($this->connection);
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

//-----------------------------------------------------------------------------------------------------------------------------------
    public function raw_sql($sql_query) {
        $this->infovars['lastquery'] = $sql_query;
        if ($sql_result = mysqli_query($this->connection, $sql_query)) {
            if (preg_match("/^(insert|delete|update|replace|truncate|drop|create|alter|set)\s+/i", $sql_query)) {
                if ($this->dbchangelog) {
                    $this->save_to_db_log($sql_query, "RawSql");
                }
            }
            return $sql_result;
        } else {
            $this->infovars['last_mysqli_error'] = mysqli_error($this->connection);
            return FALSE;
        }
    }

//-----------------------------------------------------------------------------------------------------------------------------------
    public function clear_public_vars() {
        $this->variables = array();
    }

//-----------------------------------------------------------------------------------------------------------------------------------
    public function escape($value) {
        return mysqli_real_escape_string($this->connection, $value);
    }

//-----------------------------------------------------------------------------------------------------------------------------------
    protected function save_to_db_log($sql, $addional_log = "") {
        $ip = $_SERVER['REMOTE_ADDR'];
        $logs = date("# d-m-Y H:i:s", time()) . " | " . $this->addtlog . " | " . $addional_log . " | " . $ip . "\n" . $sql . "\n";
        if (file_put_contents($this->dbchangelogfile, $logs, FILE_APPEND)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

//-----------------------------------------------------------------------------------------------------------------------------------
    public function set_add_info_to_log($add_log) {
        $this->addtlog = $add_log;
    }

//-----------------------------------------------------------------------------------------------------------------------------------
    public function get_info() { // Info değerlerini ve Public var değerlerini tablo içinde verir
        echo "<table bgcolor='#9be7dd' border='1' cellpadding='4' style='border-collapse:collapse'>";
        echo "<tr><th colspan='2' bgcolor='#cbcbcb'>Info Vars</th></tr>";
        foreach ($this->infovars as $key => $value) {
            echo '<tr>';
            echo '<td><b>' . $key . '</b></td><td>' . $value . '</td>';
            echo '</tr>';
        }
        echo "<tr><th colspan='2' bgcolor='#cbcbcb'>Public Vars</th></tr>";
        foreach ($this->variables as $key => $value) {
            echo '<tr>';
            echo '<td><b>' . $key . '</b></td><td>' . $value . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    }

//-----------------------------------------------------------------------------------------------------------------------------------
    public function is_table_exists($table_name = "") {
        if ($table_name != "") {
            $tablename = $this->escape($table_name);
        } else {
            $tablename = $this->tablename;
        }

        $sql = "SHOW TABLES LIKE '{$tablename}'";
        $this->infovars['lastquery'] = $sql;

        if (!strlen($tablename) > 0) {
            echo '<pre>Kontrol edilen tablonun ismi belirtilmedi !</pre>';
            return FALSE;

        }
        $sql_result = mysqli_query($this->connection, $sql);
        if (mysqli_num_rows($sql_result) > 0) {
            return TRUE;
        } else {
            $this->infovars['last_mysqli_error'] = mysqli_error($this->connection);
            return FALSE;
        }
    }

//-----------------------------------------------------------------------------------------------------------------------------------	
    public function create_table() {
        if ($this->class_type == 0) {
            $this->error_report("Tablo class dosyası ile oluşturulmayan örneklerle tablo oluşturulamaz");
            return FALSE;
        }
        if ($this->is_table_exists()) {
            $this->infovars['lastinfo'] = "Oluşturulmak istenen tablo zaten var !" . $this->tablename;
            return FALSE;
        } else {
            $createtablequery = "CREATE TABLE `{$this->tablename}` (";
            foreach ($this->table_fields as $field) {
                $createtablequeryfields.="`{$field['name']}` {$field['types']},";
            }
            $createtablequery.=$createtablequeryfields;
            $createtablequery.="PRIMARY KEY (`{$this->tableid}`)) ENGINE ={$this->dbengine} DEFAULT CHARSET={$this->defaultcharset}";
            $this->infovars['lastquery'] = $createtablequery;
            if (mysqli_query($this->connection, $createtablequery)) {
                if ($this->dbchangelog) {
                    $this->save_to_db_log($createtablequery, "CreateTable()");
                }
                return TRUE;
            } else {
                $this->infovars['last_mysqli_error'] = mysqli_error($this->connection);
                return FALSE;
            }
        }
    }

//----------------------------------------------------------------------------------------------------------------------------------
    public function delete_table() {
        if ($this->class_type == 0) {
            $this->error_report("Tablo class dosyası ile oluşturulmayan örneklerle tablo silinemez...! ");
            return FALSE;
        }
        if ($this->IsTableExists()) {
            $sql = "DROP TABLE `{$this->tablename}`";
            $this->infovars['lastquery'] = $sql;
            if (mysqli_query($this->connection, $sql)) {
                if ($this->dbchangelog) {
                    $this->save_to_db_log($sql, "DeleteTable()");
                }
                return TRUE;
            } else {
                $this->infovars['last_mysqli_error'] = mysqli_error($this->connection);
                return FALSE;
            }
        } else {
            $this->infovars['last_mysqli_error'] = mysqli_error($this->connection);
            $this->infovars['lastinfo'] = "Silmek istediğiniz tablo mevcut değil ! " . $this->tablename;
            return false;
        }
    }

//----------------------------------------------------------------------------------------------------------------------------------
	public function set_db_change_log($trueorfalse){
		if($trueorfalse===TRUE){
			$this->dbchangelog=true;
		} else if($trueorfalse===FALSE){
			$this->dbchangelog=false;
		}
	}

//----------------------------------------------------------------------------------------------------------------------------------
    protected function error_report($error_txt = "") {
        $this->infovars[lasterror] = $error_txt;
        trigger_error($error_txt, E_USER_WARNING);
    }
//----------------------------------------------------------------------------------------------------------------------------------

}
