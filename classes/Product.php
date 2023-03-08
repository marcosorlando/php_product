<?php
    
    class Product
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
        
        public static function save($product)
        {
            $conn = self::getConnection();
    
            var_dump($product . "<br><hr>");
            
            if (empty($product['pdt_id'])) {
                $result = $conn->query("SELECT max(pdt_id) as next FROM product");
                $row = $result->fetch();
                $product['pdt_id'] = (int)$row['next'] + 1;
                
                //Date Validate
                $product['pdt_offer_start'] = !empty($product['pdt_offer_start']) ? Check::dbDate($product['pdt_offer_start']) :
                    null;
                $product['pdt_offer_end'] = !empty($product['pdt_offer_end']) ? Check::dbDate($product['pdt_offer_end']) :
                    null;
    
                $product['pdt_cover'] = !empty($product['pdt_cover'])?:null;
                
                var_dump($product);
                
                $sql = "INSERT INTO product
                    (
                        pdt_id,
                        pdt_title,
                        pdt_subtitle,
                        pdt_tags,
                        pdt_url,
                        pdt_code,
                        pdt_un,
                        pdt_brand,
                        pdt_category,
                        pdt_description,
                        pdt_height,
                        pdt_width,
                        pdt_depth,
                        pdt_weight,
                        pdt_stock,
                        pdt_cost_price,
                        pdt_offer_price,
                        pdt_offer_percent,
                        pdt_price,
                        pdt_profit_margin,
                        pdt_offer_start,
                        pdt_offer_end,
                        pdt_cover,
                        pdt_status
                        
                    ) VALUES (
                        
                        :pdt_id,
                        :pdt_title,
                        :pdt_subtitle,
                        :pdt_tags,
                        :pdt_url,
                        :pdt_code,
                        :pdt_un,
                        :pdt_brand,
                        :pdt_category,
                        :pdt_description,
                        :pdt_height,
                        :pdt_width,
                        :pdt_depth,
                        :pdt_weight,
                        :pdt_stock,
                        :pdt_cost_price,
                        :pdt_offer_price,
                        :pdt_offer_percent,
                        :pdt_price,
                        :pdt_profit_margin,
                        :pdt_offer_start,
                        :pdt_offer_end,
                        :pdt_cover,
                        :pdt_status
                        
                    )";
            } else {
                $sql = "UPDATE product SET
                       pdt_id           =  :pdt_id,
                       pdt_title        =  :pdt_title,
                       pdt_subtitle     =  :pdt_subtitle,
                       pdt_tags         =  :pdt_tags,
                       pdt_url          =  :pdt_url,
                       pdt_code         =  :pdt_code,
                       pdt_un           =  :pdt_un,
                       pdt_brand        =  :pdt_brand,
                       pdt_category     =  :pdt_category,
                       pdt_description  =  :pdt_description,
                       pdt_height       =  :pdt_height,
                       pdt_width        =  :pdt_width,
                       pdt_depth        =  :pdt_depth,
                       pdt_weight       =  :pdt_weight,
                       pdt_stock        =  :pdt_stock,
                       pdt_cost_price   =  :pdt_cost_price,
                       pdt_offer_price  =  :pdt_offer_price,
                       pdt_offer_percent=  :pdt_offer_percent,
                       pdt_price        =  :pdt_price,
                       pdt_profit_margin=  :pdt_profit_margin,
                       pdt_offer_start  =  :pdt_offer_start,
                       pdt_offer_end    =  :pdt_offer_end,
                       pdt_cover        =  :pdt_cover,
                       pdt_status        =  :pdt_status
                                  WHERE pdt_id = :pdt_id ";
            }
            
            $result = $conn->prepare($sql);
            
            return $result->execute(
                [
                    'pdt_id' => $product['pdt_id'],
                    'pdt_title' => $product['pdt_title'],
                    'pdt_subtitle' => $product['pdt_subtitle'],
                    'pdt_tags' => $product['pdt_tags'],
                    'pdt_url' => $product['pdt_url'],
                    'pdt_code' => $product['pdt_code'],
                    'pdt_unit' => $product['pdt_unit'],
                    'pdt_brand' => $product['pdt_brand'],
                    'pdt_category' => $product['pdt_category'],
                    'pdt_description' => $product['pdt_description'],
                    'pdt_height' => $product['pdt_height'],
                    'pdt_width' => $product['pdt_width'],
                    'pdt_depth' => $product['pdt_depth'],
                    'pdt_weight' => $product['pdt_weight'],
                    'pdt_stock' => $product['pdt_stock'],
                    'pdt_cost_price' => $product['pdt_cost_price'],
                    'pdt_offer_price' => $product['pdt_offer_price'],
                    'pdt_offer_percent' => $product['pdt_offer_percent'],
                    'pdt_price' => $product['pdt_price'],
                    'pdt_profit_margin' => $product['pdt_profit_margin'],
                    'pdt_offer_start' => $product['pdt_offer_start'],
                    'pdt_offer_end' => $product['pdt_offer_end'],
                    'pdt_cover' => isset($product['pdt_cover'])?: null,
                    'pdt_status' => isset($product['pdt_status']) ? : '0'
                ]
            );
        }
        
        public static function find($id)
        {
            $conn = self::getConnection();
            $result = $conn->query("SELECT * FROM product WHERE pdt_id='{$id}'");
            
            return $result->fetch();
        }
        
        public static function delete($id)
        {
            $conn = self::getConnection();
            $result = $conn->query("DELETE FROM product WHERE pdt_id='{$id}'");
            
            return $result;
        }
        
        public static function all()
        {
            $conn = self::getConnection();
            $result = $conn->query("SELECT * FROM product");
            
            return $result;
        }
    }
