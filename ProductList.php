<?php
    
    require_once __DIR__ . '/classes/Product.php';
    
    class ProductList
    {
        private $html;
        
        public function __construct()
        {
            $this->html = file_get_contents('html/product_list.html');
        }
        
        public function delete($param)
        {
            try {
                $id = (int)$param['id'];
                Product::delete($id);
            } catch (Exception $e) {
                print $e->getMessage();
            }
        }
        
        public function load()
        {
            try {
                $companies = '';
                foreach (Product::all() as $pdt) {
                    $product = file_get_contents('html/product_view.html');
                    $product = str_replace(
                        [
                            '{pdt_id}',
                            '{pdt_title}',
                            '{pdt_subtitle}',
                            '{pdt_tags}',
                            '{pdt_url}',
                            '{pdt_code}',
                            '{pdt_un}',
                            '{pdt_brand}',
                            '{pdt_category}',
                            '{pdt_description}',
                            '{pdt_height}',
                            '{pdt_width}',
                            '{pdt_depth}',
                            '{pdt_weight}',
                            '{pdt_stock}',
                            '{pdt_cost_price}',
                            '{pdt_offer_price}',
                            '{pdt_offer_percent}',
                            '{pdt_price}',
                            '{pdt_profit_margin}',
                            '{pdt_offer_start}',
                            '{pdt_offer_end}',
                            '{pdt_status}'
                        ],
                        [
                                                      
                    $pdt['pdt_id'],
                    $pdt['pdt_title'],
                    $pdt['pdt_subtitle'],
                    $pdt['pdt_tags'],
                    $pdt['pdt_url'],
                    $pdt['pdt_code'],
                    $pdt['pdt_un'],
                    $pdt['pdt_brand'],
                    $pdt['pdt_category'],
                    $pdt['pdt_description'],
                    $pdt['pdt_height'],
                    $pdt['pdt_width'],
                    $pdt['pdt_depth'],
                    $pdt['pdt_weight'],
                    $pdt['pdt_stock'],
                    $pdt['pdt_cost_price'],
                    $pdt['pdt_offer_price'],
                    $pdt['pdt_offer_percent'],
                    $pdt['pdt_price'],
                    $pdt['pdt_profit_margin'],
                    $pdt['pdt_offer_start'],
                    $pdt['pdt_offer_end'],
                    $pdt['pdt_status']
                        ],
                        $product
                    );
                    
                    $products .= $product;
                }
                $this->html = str_replace(
                    '{products}',
                    $companies,
                    $this->html
                );
            } catch (Exception $e) {
                print $e->getMessage();
            }
        }
        
        public function show()
        {
            $this->load();
            print $this->html;
        }
    }
