<?php 
return [
  'accepted' => 'O :attribute deve ser aceito.',
  'active_url' => 'O :attribute não é um URL válido.',
  'after' => 'O :attribute deve ser uma data após :date.',
  'after_or_equal' => 'O :attribute deve ser uma data após ou igual a :date.',
  'alpha' => 'O :attribute só pode conter letras.',
  'alpha_dash' => 'O :attribute pode conter apenas letras, números, traços e sublinhados.',
  'alpha_num' => 'O :attribute pode conter apenas letras e números.',
  'array' => 'O :attribute deve ser uma matriz.',
  'before' => 'O :attribute deve ser uma data antes do :date.',
  'before_or_equal' => 'O :attribute deve ser uma data antes ou igual a :date.',
  'between' => [
    'numeric' => 'O :attribute deve estar entre :min e :max.',
    'file' => 'O :attribute deve estar entre :min e :max kilobytes.',
    'string' => 'O :attribute deve estar entre os caracteres :min e :max.',
    'array' => 'O :attribute deve ter entre os itens :min e :max.',
  ],
  'boolean' => 'O campo :attribute deve ser verdadeiro ou falso.',
  'confirmed' => 'A confirmação :attribute não corresponde.',
  'date' => 'O :attribute não é uma data válida.',
  'date_equals' => 'O :attribute deve ser uma data igual a :date.',
  'date_format' => 'O :attribute não corresponde ao formato :format.',
  'different' => 'O :attribute e :other devem ser diferentes.',
  'digits' => 'O :attribute deve ser :digits dígitos.',
  'digits_between' => 'O :attribute deve estar entre :min e :max dígitos.',
  'dimensions' => 'O :attribute tem dimensões de imagem inválidas.',
  'distinct' => 'O campo :attribute tem um valor duplicado.',
  'email' => 'O :attribute deve ser um endereço de e-mail válido.',
  'ends_with' => 'O :attribute deve terminar com um dos seguintes: :values.',
  'exists' => 'O :attribute selecionado é inválido.',
  'file' => 'O :attribute deve ser um arquivo.',
  'filled' => 'O campo :attribute deve ter um valor.',
  'gt' => [
    'numeric' => 'O :attribute deve ser maior que :value.',
    'file' => 'O :attribute deve ser maior que :value kilobytes.',
    'string' => 'O :attribute deve ser maior que o :value caracteres.',
    'array' => 'O :attribute deve ter mais de :value itens.',
  ],
  'gte' => [
    'numeric' => 'O :attribute deve ser maior ou igual ao :value.',
    'file' => 'O :attribute deve ser maior ou igual a :value kilobytes.',
    'string' => 'O :attribute deve ser maior ou igual a :value caracteres.',
    'array' => 'O :attribute deve ter itens :value ou mais.',
  ],
  'image' => 'O :attribute deve ser uma imagem.',
  'in' => 'O :attribute selecionado é inválido.',
  'in_array' => 'O campo :attribute não existe em :other.',
  'integer' => 'O :attribute deve ser um inteiro.',
  'ip' => 'O :attribute deve ser um endereço IP válido.',
  'ipv4' => 'O :attribute deve ser um endereço IPv4 válido.',
  'ipv6' => 'O :attribute deve ser um endereço IPv6 válido.',
  'json' => 'O :attribute deve ser uma string JSON válida.',
  'lt' => [
    'numeric' => 'O :attribute deve ser menor que :value.',
    'file' => 'O :attribute deve ser menor que :value kilobytes.',
    'string' => 'O :attribute deve ser inferior a :value caracteres.',
    'array' => 'O :attribute deve ter menos de :value itens.',
  ],
  'lte' => [
    'numeric' => 'O :attribute deve ser menor ou igual :value.',
    'file' => 'O :attribute deve ser menor ou igual :value kilobytes.',
    'string' => 'O :attribute deve ser menor ou igual ou igual a :value caracteres.',
    'array' => 'O :attribute não deve ter mais de :value itens.',
  ],
  'max' => [
    'numeric' => 'O :attribute pode não ser maior que :max.',
    'file' => 'O :attribute pode não ser maior que :max kilobytes.',
    'string' => 'O :attribute pode não ser maior que os caracteres :max.',
    'array' => 'O :attribute pode não ter mais de :max itens.',
  ],
  'mimes' => 'O :attribute deve ser um arquivo do tipo: :values.',
  'mimetypes' => 'O :attribute deve ser um arquivo do tipo: :values.',
  'min' => [
    'numeric' => 'O :attribute deve ser pelo menos :min.',
    'file' => 'O :attribute deve ser pelo menos :min kilobytes.',
    'string' => 'O :attribute deve ter pelo menos caracteres :min.',
    'array' => 'O :attribute deve ter pelo menos itens :min.',
  ],
  'not_in' => 'O :attribute selecionado é inválido.',
  'not_regex' => 'O formato :attribute é inválido.',
  'numeric' => 'O :attribute deve ser um número.',
  'password' => 'A senha está incorreta.',
  'present' => 'O campo :attribute deve estar presente.',
  'regex' => 'O formato :attribute é inválido.',
  'required' => 'O campo :attribute é necessário.',
  'required_if' => 'O campo :attribute é necessário quando o :other é :value.',
  'required_unless' => 'O campo :attribute é necessário, a menos que o :other esteja em :values.',
  'required_with' => 'O campo :attribute é necessário quando :values está presente.',
  'required_with_all' => 'O campo :attribute é necessário quando :values estão presentes.',
  'required_without' => 'O campo :attribute é necessário quando :values não está presente.',
  'required_without_all' => 'O campo :attribute é necessário quando nenhum de :values está presente.',
  'same' => 'O :attribute e :other devem corresponder.',
  'size' => [
    'numeric' => 'O :attribute deve ser :size.',
    'file' => 'O :attribute deve ser :size kilobytes.',
    'string' => 'O :attribute deve ser :size caracteres.',
    'array' => 'O :attribute deve conter itens :size.',
  ],
  'starts_with' => 'O :attribute deve começar com um dos seguintes: :values.',
  'string' => 'O :attribute deve ser uma string.',
  'timezone' => 'O :attribute deve ser uma zona válida.',
  'unique' => 'O :attribute já foi tomado.',
  'uploaded' => 'O :attribute falhou ao upload.',
  'url' => 'O formato :attribute é inválido.',
  'uuid' => 'O :attribute deve ser um UUID válido.',
  'custom' => [
    'attribute-name' => [
      'rule-name' => 'mensagem personalizada',
    ],
  ],
  'attributes' => [
  ],
];