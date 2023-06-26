<?php

return [

    /*FIXME: upravit překlady pro češtinu.
            Doufám, že jsou všechny proměnné správně
            kdyžtak to zkontroluj v souboru 
            vendor\laravel\framework\src\Illuminate\Validation\resources\lang\en\validation.php
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'Pole :attribute musí být přijato.',
    'accepted_if' => 'Pole :attribute musí být přijato, když :other je :value.',
    'active_url' => 'Pole :attribute musí být platné URL.',
    'after' => 'Pole :attribute musí být datum po :date.',
    'after_or_equal' => 'Pole :attribute musí být datum po nebo rovno :date.',
    'alpha' => 'Pole :attribute smí obsahovat pouze písmena.',
    'alpha_dash' => 'Pole :attribute smí obsahovat pouze písmena, čísla, pomlčky a podtržítka.',
    'alpha_num' => 'Pole :attribute smí obsahovat pouze písmena a čísla.',
    'array' => 'Pole :attribute musí být pole.',
    'ascii' => 'Pole :attribute smí obsahovat pouze jednobajtové alfanumerické znaky a symboly.',
    'before' => 'Pole :attribute musí být datum před :date.',
    'before_or_equal' => 'Pole :attribute musí být datum před nebo rovno :date.',
    'between' => [
        'array' => 'Pole :attribute musí mít mezi :min a :max položkami.',
        'file' => 'Pole :attribute musí být mezi :min a :max kilobajty.',
        'numeric' => 'Pole :attribute musí být mezi :min a :max.',
        'string' => 'Pole :attribute musí být mezi :min a :max znaky.',
    ],
    'boolean' => 'Pole :attribute musí být pravda nebo nepravda.',
    'confirmed' => 'Potvrzení pole :attribute se neshoduje.',
    'current_password' => 'Heslo je nesprávné.',
    'date' => 'Pole :attribute musí být platné datum.',
    'date_equals' => 'Pole :attribute musí být datum rovno :date.',
    'date_format' => 'Pole :attribute musí odpovídat formátu :format.',
    'decimal' => 'Pole :attribute musí mít :decimal desetinných míst.',
    'declined' => 'Pole :attribute musí být zamítnuto.',
    'declined_if' => 'Pole :attribute musí být zamítnuto, když :other je :value.',
    'different' => 'Pole :attribute a :other musí být odlišné.',
    'digits' => 'Pole :attribute musí být :digits číslic.',
    'digits_between' => 'Pole :attribute musí být mezi :min a :max číslicemi.',
    'dimensions' => 'Pole :attribute má neplatné rozměry obrázku.',
    'distinct' => 'Pole :attribute má duplicitní hodnotu.',
    'doesnt_end_with' => 'Pole :attribute nesmí končit jedním z následujících: :values.',
    'doesnt_start_with' => 'Pole :attribute nesmí začínat jedním z následujících: :values.',
    'email' => 'Pole :attribute musí být platná emailová adresa.',
    'ends_with' => 'Pole :attribute musí končit jedním z následujících: :values.',
    'enum' => 'Vybraná položka pro :attribute je neplatná.',
    'exists' => 'Vybraná položka pro :attribute je neplatná.',
    'file' => 'Pole :attribute musí být soubor.',
    'filled' => 'Pole :attribute musí mít hodnotu.',
    'gt' => [
    'array' => 'Pole :attribute musí mít více než :value položek.',
    'file' => 'Pole :attribute musí být větší než :value kilobytů.',
    'numeric' => 'Pole :attribute musí být větší než :value.',
    'string' => 'Pole :attribute musí být delší než :value znaků.',
    ],
    'gte' => [
    'array' => 'Pole :attribute musí mít :value položek nebo více.',
    'file' => 'Pole :attribute musí být větší nebo rovno :value kilobytů.',
    'numeric' => 'Pole :attribute musí být větší nebo rovno :value.',
    'string' => 'Pole :attribute musí být delší nebo rovno :value znaků.',
    ],
    'image' => 'Pole :attribute musí být obrázek.',
    'in' => 'Vybraná položka pro :attribute je neplatná.',
    'in_array' => 'Pole :attribute musí být součástí :other.',
    'integer' => 'Pole :attribute musí být celé číslo.',
    'ip' => 'Pole :attribute musí být platná IP adresa.',
    'ipv4' => 'Pole :attribute musí být platná IPv4 adresa.',
    'ipv6' => 'Pole :attribute musí být platná IPv6 adresa.',
    'json' => 'Pole :attribute musí být platný JSON řetězec.',
    'lowercase' => 'Pole :attribute musí být malá písmena.',
    'lt' => [
    'array' => 'Pole :attribute musí mít méně než :value položek.',
    'file' => 'Pole :attribute musí být menší než :value kilobytů.',
    'numeric' => 'Pole :attribute musí být menší než :value.',
    'string' => 'Pole :attribute musí být kratší než :value znaků.',
    ],
    'lte' => [
    'array' => 'Pole :attribute nesmí mít více než :value položek.',
    'file' => 'Pole :attribute musí být menší nebo rovno :value kilobytů.',
            'numeric' => 'Pole :attribute musí být menší nebo rovno :value.',
            'string' => 'Pole :attribute musí míň méně nebo rovno :value znaků.',
        ],
    'mac_address' => 'Pole :attribute musí být platnou MAC adresou.',
    'max' => [
    'array' => 'Pole :attribute nesmí mít více než :max položek.',
    'file' => 'Soubor v poli :attribute nesmí být větší než :max kilobytů.',
    'numeric' => 'Hodnota v poli :attribute nesmí být větší než :max.',
    'string' => 'Text v poli :attribute nesmí být delší než :max znaků.',
    ],
    'max_digits' => 'Pole :attribute nesmí mít více než :max číslic.',
    'mimes' => 'Soubor v poli :attribute musí být jedním z typů: :values.',
    'mimetypes' => 'Soubor v poli :attribute musí být jedním z typů: :values.',
    'min' => [
    'array' => 'Pole :attribute musí mít alespoň :min položek.',
    'file' => 'Soubor v poli :attribute musí být minimálně :min kilobytů velký.',
    'numeric' => 'Hodnota v poli :attribute musí být minimálně :min.',
    'string' => 'Text v poli :attribute musí mít alespoň :min znaků.',
    ],
    'min_digits' => 'Pole :attribute musí mít alespoň :min číslic.',
    'missing' => 'Pole :attribute musí být prázdné.',
    'missing_if' => 'Pole :attribute musí být prázdné, pokud :other je :value.',
    'missing_unless' => 'Pole :attribute musí být prázdné, pokud :other není :value.',
    'missing_with' => 'Pole :attribute musí být prázdné, pokud je přítomno :values.',
    'missing_with_all' => 'Pole :attribute musí být prázdné, pokud jsou přítomny :values.',
    'multiple_of' => 'Hodnota v poli :attribute musí být násobkem čísla :value.',
    'not_in' => 'Vybraná hodnota v poli :attribute je neplatná.',
    'not_regex' => 'Formát textu v poli :attribute je neplatný.',
    'numeric' => 'Pole :attribute musí být číslo.',
    'password' => [
    'letters' => 'Pole :attribute musí obsahovat alespoň jedno písmeno.',
    'mixed' => 'Pole :attribute musí obsahovat alespoň jedno velké a jedno malé písmeno.',
    'numbers' => 'Pole :attribute musí obsahovat alespoň jedno číslo.',
    'symbols' => 'Pole :attribute musí obsahovat alespoň jeden symbol.',
    'uncompromised' => 'Heslo v poli :attribute se objevilo v úniku dat. Vyberte prosím jiné heslo.',
    ],
    'present' => 'Pole :attribute musí být přítomno.',
    'prohibited' => 'Pole :attribute je zakázáno.',
    'prohibited_if' => 'Pole :attribute je zakázáno, když :other je :value.',
    'prohibited_unless' => 'Pole :attribute je zakázáno, pokud :other není v :values.',
    'prohibits' => 'Pole :attribute zakazuje, aby :other bylo přítomno.',
    'regex' => 'Formát pole :attribute je neplatný.',
    'required' => 'Pole :attribute je povinné.',
    'required_array_keys' => 'Pole :attribute musí obsahovat položky pro: :values.',
    'required_if' => 'Pole :attribute je povinné, když :other je :value.',
    'required_if_accepted' => 'Pole :attribute je povinné, když je :other přijato.',
    'required_unless' => 'Pole :attribute je povinné, pokud :other není v :values.',
    'required_with' => 'Pole :attribute je povinné, když jsou přítomny :values.',
    'required_with_all' => 'Pole :attribute je povinné, když jsou přítomny všechny hodnoty :values.',
    'required_without' => 'Pole :attribute je povinné, když :values nejsou přítomny.',
    'required_without_all' => 'Pole :attribute je povinné, pokud nejsou přítomny žádné hodnoty :values.',
    'same' => 'Pole :attribute se musí shodovat s :other.',
    'size' => [
    'array' => 'Pole :attribute musí obsahovat :size položek.',
    'file' => 'Pole :attribute musí být :size kilobytů velké.',
    'numeric' => 'Pole :attribute musí být :size.',
    'string' => 'Pole :attribute musí být :size znaků dlouhé.',
    ],
    'starts_with' => 'Pole :attribute musí začínat jednou z následujících hodnot: :values.',
    'string' => 'Pole :attribute musí být řetězec.',
    'timezone' => 'Pole :attribute musí být platné časové pásmo.',
    'unique' => ':Attribute již byl obsazen.',
    'uploaded' => ':Attribute se nepodařilo nahrát.',
    'uppercase' => 'Pole :attribute musí být velká písmena.',
    'url' => 'Pole :attribute musí být platná URL adresa.',
    'ulid' => 'Pole :attribute musí být platný ULID.',
    'uuid' => 'Pole :attribute musí být platné UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
