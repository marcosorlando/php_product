<?php
    
    require_once __DIR__ . '/classes/Company.php';
    
    
    
    class CompanyForm
    {
        private $html;
        private $data;
        
        public function __construct()
        {
            $this->html = file_get_contents('html/form.html');
            $this->data = [
                'company_id' => null,
                'company_cnpj' => null,
                'company_name' => null,
                'company_fantasy' => null,
                'company_cep' => null,
                'company_address' => null,
                'company_number' => null,
                'company_complement' => null,
                'company_district' => null,
                'company_city' => null,
                'company_state' => null,
                'company_phone' => null,
                'company_mail' => null
            ];
        }
        
        public function edit($param)
        {
            try {
                $id = (int)$param['id'];
                $company = Company::find($id);
                $this->data = $company;
            } catch (Exception $e) {
                print $e->getMessage();
            }
        }
        
        public function save($company)
        {
            if (array_search('', $company) && array_search('', $company) != 'company_fantasy' && array_search('',
                    $company) != 'company_complement') {
                print "<div class='trigger trigger-error center'><p>Preencha todos os campos *obrigatórios!</p></div>";
    
    
            } elseif (!filter_var($company['company_mail'], FILTER_VALIDATE_EMAIL)) {
                echo "<div class='trigger trigger-error center'><p>O e-mail informado não é válido!</p></div>";
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
                
                foreach ($company as $key => $value) {
                    if ($key == 'company_mail') {
                        $company[$key] = mb_convert_case($value, MB_CASE_LOWER);
                    } elseif ($key == 'company_state') {
                        $company[$key] = mb_convert_case($value, MB_CASE_UPPER);
                    } else {
                        $company[$key] = getCapilalize($value);
                    }
                }
                
                try {
                    Company::save($company);
                    $this->data = $company;
                    print "<div class='trigger trigger-sucess center'><p>Empresa salva com Sucesso!</p></div>";
                } catch (Exception $e) {
                    print $e->getMessage();
                }
            }
        }
        
        public function show()
        {
            $this->html = str_replace(
                [
                    '{company_id}',
                    '{company_cnpj}',
                    '{company_name}',
                    '{company_fantasy}',
                    '{company_cep}',
                    '{company_address}',
                    '{company_number}',
                    '{company_complement}',
                    '{company_district}',
                    '{company_city}',
                    '{company_state}',
                    '{company_phone}',
                    '{company_mail}'
                ],
                [
                    $this->data['company_id'],
                    $this->data['company_cnpj'],
                    $this->data['company_name'],
                    $this->data['company_fantasy'],
                    $this->data['company_cep'],
                    $this->data['company_address'],
                    $this->data['company_number'],
                    $this->data['company_complement'],
                    $this->data['company_district'],
                    $this->data['company_city'],
                    $this->data['company_state'],
                    $this->data['company_phone'],
                    $this->data['company_mail']
                ],
                $this->html
            );
            
            print  $this->html;
        }
        
    }
