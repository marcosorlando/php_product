<?php
    
    require_once __DIR__ . '/config/config.php';
    require_once __DIR__ . '/classes/Product.php';
    require_once __DIR__ . '/classes/helpers/Check.class.php';
    require_once __DIR__ . '/classes/helpers/Upload.php';
    
    class ProductForm
    {
        private $html;
        private $data;
        
        public function __construct()
        {
            $this->html = file_get_contents('html/product_form.html');
            $this->data = [
                'pdt_id' => null,
                'pdt_title' => 'Teste',
                'pdt_subtitle' => 'testando',
                'pdt_tags' => 'teste, teste2, teste3',
                'pdt_url' => null,
                'pdt_code' => 1,
                'pdt_un' => 1,
                'pdt_brand' => 1,
                'pdt_category' => 1,
                'pdt_description' => 'descricao',
                'pdt_height' => 10,
                'pdt_width' => 20,
                'pdt_depth' => 30,
                'pdt_weight' => 0.300,
                'pdt_stock' => 3,
                'pdt_cost_price' => 5,
                'pdt_offer_price' => 3,
                'pdt_offer_percent' => 10,
                'pdt_price' => 10,
                'pdt_profit_margin' => 5,
                'pdt_offer_start' => '2023-03-07 18:00',
                'pdt_offer_end' => '2023-04-07 18:00',
                'pdt_cover' => null,
                'pdt_status' => 1
            ];
        }
        
        public function options($table)
        {
            $conn = Product::getConnection();
            $result = $conn->query("SELECT * FROM " . $table)->fetchAll(PDO::FETCH_ASSOC);
            
            if ($result) {
                $options = "<option value='' selected disabled >Selecione uma opção</option>";
                
                foreach ($result as $opt) {
                    $value = ($table == 'product_brands' ? 'brand_name' :
                        ($table == 'product_units' ? 'un_title' :
                            ($table == 'product_categories' ? 'cat_title' : null)
                        ));
                    
                    $options .= "<option value=\"{$opt['id']}\">{$opt[$value]}</option>";
                }
            } else {
                $options = "<option value='' selected disabled >Cadastre primeiro uma unidade medida.</option>";
            }
            
            return $options;
        }
    
       /* public function upload($file)
        {
            $getPost = filter_input(INPUT_GET, 'method', FILTER_VALIDATE_BOOLEAN);
    
            if ($_FILES && !empty($_FILES['file']['name'])) {
                $fileUpload = $_FILES['file'];
        
                $allowedTypes = [
                    'image/jpg',
                    'image/jpeg',
                    'image/png',
                    'application/pdf',
                    'application/vnd.ms-excel'
                ];
        
                $newFileName = time() . mb_strstr($fileUpload['name'], '.');
        
                if(in_array($fileUpload['type'], $allowedTypes)) {
                    if(move_uploaded_file($fileUpload['tmp_name'], __DIR__."/uploads/{$newFileName}")){
                        echo "<p class='trigger accept'>Arquivo enviado com sucesso!</p>";
                    }else{
                        echo "<p class='trigger error'>Erro inesperado.</p>";
                    }
            
                } else {
                    echo "<p class='trigger error'>Tipo de arquivo não permitido.</p>";
                }
        
            } elseif ($getPost && !$_FILES){
                echo "<p class='trigger warning'>Parece que o arquivo é muito grande.</p>";
            } else {
                echo "<p class='trigger warning'>Selecione um arquivo antes de enviar!</p>";
            }
            
            
        }*/
        
        public function edit($param)
        {
            try {
                $id = (int)$param['pdt_id'];
                $product = Product::find($id);
    
                var_dump(['edit' =>$product]);
    
                $this->data = $product;
            } catch (Exception $e) {
                print $e->getMessage();
            }
        }
        
        public function save($product)
        {
            if (array_search('', $product)) {
                print "<div class='trigger trigger-error center'><p>Preencha todos os campos *obrigatórios!</p></div>";
            } else {
                function getCapilalize($str)
                {
                    $pattern = "/^[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$/";
                    $str = trim(preg_replace('/[0-9\_\@\.\;\" "]+/', ' ', $str));
                    
                    preg_match($pattern, $str, $match);
                    if (!empty($match)) {
                        $str = ucwords(mb_strtolower($str));
                        $str = str_replace([' De ', ' Da ', ' Do '], [' de ', ' da ', ' do '], $str);
                    }
                    
                    return $str;
                }
    
                //UPLOAD AVATAR-IMAGE
                if (!empty($_FILES['pdt_cover'])):
                    $File = $_FILES['pdt_cover'];
        
                    /*if ($ThisPage['pdt_cover'] && file_exists("../../uploads/images/{$ThisPage['pdt_cover']}") && !is_dir("../../uploads/images/{$ThisPage['pdt_cover']}")):
                        unlink("../../uploads/images/{$ThisPage['pdt_cover']}");
                    endif;*/
        
                    $Upload = new Upload('/uploads/images/');
                    $Upload->Image($File, $product['pdt_name'], '400');
        
                    if ($Upload->getResult()):
                        $product['pdt_cover'] = $Upload->getResult();
                    else:
                        $jSON['trigger'] = AjaxErro("<b class='icon-image'>ERRO AO ENVIAR FOTO:</b> Olá {$_SESSION['userLogin']['user_name']}, selecione uma imagem JPG ou PNG para enviar como foto!", E_USER_WARNING);
                        echo json_encode($jSON);
                        return;
                    endif;
                else:
                    unset($product['pdt_cover']);
                endif;
                
                foreach ($product as $key => $value) {
                    $product[$key] = getCapilalize($value);
                }
                
                try {
                    Product::save($product);
                    $this->data = $product;
                    print "<div class='trigger trigger-sucess center'><p>Produto salvo com Sucesso!</p></div>";
                } catch (Exception $e) {
                    print $e->getMessage();
                }
            }
        }
        
        public function show()
        {
            $this->html = str_replace(
                [
                    '{pdt_id}',
                    '{pdt_title}',
                    '{pdt_subtitle}',
                    '{pdt_tags}',
                    '{pdt_url}',
                    '{pdt_code}',
                    '{pdt_unit}',
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
                    '{pdt_cover}',
                    '{pdt_status}'
                ],
                [
                    $this->data['pdt_id'],
                    $this->data['pdt_title'],
                    $this->data['pdt_subtitle'],
                    $this->data['pdt_tags'],
                    $this->data['pdt_url'],
                    $this->data['pdt_code'],
                    self::options('product_units'),
                    self::options('product_brands'),
                    self::options('product_categories'),
                    $this->data['pdt_description'],
                    $this->data['pdt_height'],
                    $this->data['pdt_width'],
                    $this->data['pdt_depth'],
                    $this->data['pdt_weight'],
                    $this->data['pdt_stock'],
                    $this->data['pdt_cost_price'],
                    $this->data['pdt_offer_price'],
                    $this->data['pdt_offer_percent'],
                    $this->data['pdt_price'],
                    $this->data['pdt_profit_margin'],
                    $this->data['pdt_offer_start'],
                    $this->data['pdt_offer_end'],
                    (!empty($this->data['pdt_cover'])?: BASE.'/parte-1.png')
                ],
                $this->html
            );
            
            print  $this->html;
        }
        
    }
