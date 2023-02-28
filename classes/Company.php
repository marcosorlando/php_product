<?php
    
    class Company
    {
        private static $conn;
        
        public static function getConnection()
        {
            if (empty(self::$conn)) {
                $connection = parse_ini_file('config/db.ini');
                self::$conn = new PDO(
                    "mysql:host={$connection['host']};port={$connection['port']};dbname={$connection['name']}",
                    "{$connection['user']}",
                    "{$connection['pass']}",
                    [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8']
                );
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            
            return self::$conn;
        }
        
        public static function save($company)
        {
            $conn = self::getConnection();
            if (empty($company['company_id'])) {
                $result = $conn->query("SELECT max(company_id) as next FROM company");
                $row = $result->fetch();
                $company['company_id'] = (int)$row['next'] + 1;
                $sql = "INSERT INTO company
                    (
                        company_id,
                        company_cnpj,
                        company_name,
                        company_fantasy,
                        company_cep,
                        company_address,
                        company_number,
                        company_complement,
                        company_district,
                        company_city,
                        company_state,
                        company_phone,
                        company_mail
                    ) VALUES (
                        :company_id,
                        :company_cnpj,
                        :company_name,
                        :company_fantasy,
                        :company_cep,
                        :company_address,
                        :company_number,
                        :company_complement,
                        :company_district,
                        :company_city,
                        :company_state,
                        :company_phone,
                        :company_mail
                    )";
            } else {
                $sql = "UPDATE company SET
                        company_id = :company_id,
                        company_cnpj = :company_cnpj,
                        company_name = :company_name,
                        company_fantasy = :company_fantasy,
                        company_cep = :company_cep,
                        company_address = :company_address,
                        company_number = :company_number,
                        company_complement = :company_complement,
                        company_district = :company_district,
                        company_city = :company_city,
                        company_state = :company_state,
                        company_phone = :company_phone,
                        company_mail = :company_mail
                   WHERE company_id = :company_id ";
            }
            
            $result = $conn->prepare($sql);
            
            return $result->execute(
                [
                    ':company_id' => $company['company_id'],
                    ':company_cnpj' => $company['company_cnpj'],
                    ':company_name' => $company['company_name'],
                    ':company_fantasy' => $company['company_fantasy'],
                    ':company_cep' => $company['company_cep'],
                    ':company_address' => $company['company_address'],
                    ':company_number' => $company['company_number'],
                    ':company_complement' => $company['company_complement'],
                    ':company_district' => $company['company_district'],
                    ':company_city' => $company['company_city'],
                    ':company_state' => $company['company_state'],
                    ':company_phone' => $company['company_phone'],
                    ':company_mail' => $company['company_mail']
                ]
            );
        }
        
      
        public static function find($id)
        {
            $conn = self::getConnection();
            $result = $conn->query("SELECT * FROM company WHERE company_id='{$id}'");
            
            return $result->fetch();
        }
        
        public static function delete($id)
        {
            $conn = self::getConnection();
            $result = $conn->query("DELETE FROM company WHERE company_id='{$id}'");
            
            return $result;
        }
        
        public static function all()
        {
            $conn = self::getConnection();
            $result = $conn->query("SELECT * FROM company");
            
            return $result;
        }
    }
