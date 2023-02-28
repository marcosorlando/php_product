<?php
    
    require_once __DIR__ . '/classes/Company.php';
    
    class CompanyList
    {
        private $html;
        
        public function __construct()
        {
            $this->html = file_get_contents('html/list.html');
        }
        
        public function delete($param)
        {
            try {
                $id = (int)$param['id'];
                Company::delete($id);
            } catch (Exception $e) {
                print $e->getMessage();
            }
        }
        
        public function load()
        {
            try {
                $companies = '';
                foreach (Company::all() as $co) {
                    $company = file_get_contents('html/company.html');
                    $company = str_replace(
                        [
                            '{company_id}',
                            '{company_cnpj}',
                            '{company_name}',
                            '{company_city}',
                            '{company_state}',
                            '{company_phone}',
                            '{company_mail}'
                        ],
                        [
                            $co['company_id'],
                            $co['company_cnpj'],
                            ($co['company_fantasy']?:$co['company_name']),
                            $co['company_city'],
                            $co['company_state'],
                            $co['company_phone'],
                            $co['company_mail']
                        ],
                        $company
                    );
                    
                    $companies .= $company;
                }
                $this->html = str_replace(
                    '{companies}',
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
