<?php


class Validator {

    protected $db;
    protected $errorHandler;
    protected $rules = ['required','minlength', 'maxlength','email','alnum','match','unique'];
    protected $items;

    public $messages = [
        'required' => 'The :field field is required',
        'minlength' => 'The :field field must be a minimum of :satisifer length',
        'maxlength' => 'The :field field must be a maximum of :satisifer length',
        'email' => 'That is not a vallid email address',
        'alnum' => 'The :field field must be alphanumeric',
        'match' => 'The :field field must match the :satisifer field',
        'unique' => 'That :field is already taken'

    ];

    public function __construct(Database $db, ErrorHandler $errorHandler){
        $this->db =$db;
        $this->errorHandler = $errorHandler;
    }

    public function check($items,$rules){

        $this->items = $items;
        foreach($items as $item => $value){
           if(in_array($item, array_keys($rules))){
               $this->validate([
                'field' => $item,
                'value' => $value,
                'rules' => $rules[$item]
               ]);
           }
        }
        return $this;
    }

        public function fails(){
            return $this->errorHandler->hasErrors();
        }

        protected function validate($item){

            $field = $item['field'];

            foreach($item['rules'] as $rule => $satisifer){
                if(in_array($rule, $this->rules)){
                   if(!call_user_func_array([$this,$rule], [$field,$item['value'],$satisifer])){
                    $this->errorHandler->addError(
                        str_replace([':field', ':satisifer'], [$field,$satisifer], $this->messages[$rule]), 
                        $field
                                );
                   }
                }
            }
        }

        public function errors(){
            return $this->errorHandler;
        }

        protected function required($field, $value, $satisifer){
            return !empty(trim($value));
        }
        protected function minlength($field, $value, $satisifer){
            return mb_strlen($value) >=$satisifer;
        }

        protected function maxlength($field, $value, $satisifer){
            return mb_strlen($value) <=$satisifer;
        }

        protected function email($field, $value, $satisifer){
            return filter_var($value, FILTER_VALIDATE_EMAIL);
        }

        protected function alnum($field, $value, $satisifer){
            return ctype_alnum($value);
        }

        protected function match($field, $value, $satisifer){
            return $value === $this->items[$satisifer];
        }

        protected function unique($field, $value, $satisifer){
           return !$this->db->table($satisifer)->exists([
                $field => $value
           ]);
        }
}