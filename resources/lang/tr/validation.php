<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => ':attribute kabul edilmelidir.',
    'active_url'           => ':attribute geçerli bir URL olmalıdır.',
    'after'                => ':attribute :date tarihinden sonra bir tarih olmalıdır.',
    'after_or_equal'       => ':attribute :date tarihinden sonra veya tarihine eşit bir tarih olmalıdır.',
    'alpha'                => ':attribute sadece harf içerebilir.',
    'alpha_dash'           => ':attribute yalnızca harfler, rakamlar, tireler ve alt çizgiler içerebilir.',
    'alpha_num'            => ':attribute yalnızca harf ve rakam içerebilir.',
    'array'                => ':attribute bir dizi olmalıdır.',
    'before'               => ':attribute :date tarihinden önce bir tarih olmalıdır.',
    'before_or_equal'      => ':attribute :date tarihinden önce veya tarihine eşit bir tarih olmalıdır.',
    'between'              => [
        'numeric' => ':attribute :min ile :max arasında olmalıdır.',
        'file'    => ':attribute :min ile :max kilobayt arasında olmalıdır.',
        'string'  => ':attribute :min ile :max karakter arasında olmalıdır.',
        'array'   => ':attribute :min ile :max arasında öğe içermelidir.',
    ],
    'boolean'              => ':attribute alanı doğru veya yanlış olmalıdır.',
    'confirmed'            => ':attribute onayı eşleşmiyor.',
    'date'                 => ':attribute geçerli bir tarih değil.',
    'date_equals'          => ':attribute, :date tarihine eşit olmalıdır.',
    'date_format'          => ':attribute, :format formatıyla eşleşmiyor.',
    'different'            => ':attribute ve :other farklı olmalıdır.',
    'digits'               => ':attribute :digits rakam olmalıdır.',
    'digits_between'       => ':attribute, :min ile :max arasında rakam içermelidir.',
    'dimensions'           => ':attribute geçersiz resim boyutlarına sahiptir.',
    'distinct'             => ':attribute alanı yinelenen bir değere sahiptir.',
    'email'                => ':attribute geçerli bir e-posta adresi olmalıdır.',
    'ends_with'            => ':attribute aşağıdakilerden biriyle bitmelidir: :values',
    'exists'               => 'Seçili :attribute geçersiz.',
    'file'                 => ':attribute bir dosya olmalıdır.',
    'filled'               => ':attribute alanı doldurulmalıdır.',
    'gt'                   => [
        'numeric' => ':attribute, :value değerinden büyük olmalıdır.',
        'file'    => ':attribute, :value kilobaytdan büyük olmalıdır.',
        'string'  => ':attribute, :value karakterden uzun olmalıdır.',
        'array'   => ':attribute, :value öğeden daha fazla olmalıdır.',
    ],
    'gte'                  => [
        'numeric' => ':attribute, :value değerine eşit veya daha büyük olmalıdır.',
        'file'    => ':attribute, :value kilobayt eşit veya daha büyük olmalıdır.',
        'string'  => ':attribute, :value karakter eşit veya daha büyük olmalıdır.',
        'array'   => ':attribute, :value öğe eşit veya daha fazla olmalıdır.',
    ],
    'image'                => ':attribute bir resim olmalıdır.',
    'in'                   => 'Seçilen :attribute geçersiz.',
    'in_array'             => ':attribute, :other içinde bulunmamaktadır.',
    'integer'              => ':attribute bir tam sayı olmalıdır.',
    'ip'                   => ':attribute geçerli bir IP adresi olmalıdır.',
    'ipv4'                 => ':attribute geçerli bir IPv4 adresi olmalıdır.',
    'ipv6'                 => ':attribute geçerli bir IPv6 adresi olmalıdır.',
    'json'                 => ':attribute geçerli bir JSON dizesi olmalıdır.',
    'lt'                   => [
        'numeric' => ':attribute, :value değerinden küçük olmalıdır.',
        'file'    => ':attribute, :value kilobaytdan küçük olmalıdır.',
        'string'  => ':attribute, :value karakterden kısa olmalıdır.',
        'array'   => ':attribute, :value öğeden daha az olmalıdır.',
    ],
    'lte'                  => [
        'numeric' => ':attribute, :value değerine eşit veya daha küçük olmalıdır.',
        'file'    => ':attribute, :value kilobayt eşit veya daha küçük olmalıdır.',
        'string'  => ':attribute, :value karakter eşit veya daha kısa olmalıdır.',
        'array'   => ':attribute, :value öğe eşit veya daha az olmalıdır.',
    ],
    'max'                  => [
        'numeric' => ':attribute, :max değerinden büyük olmamalıdır.',
        'file'    => ':attribute, :max kilobayttan büyük olmamalıdır.',
        'string'  => ':attribute, :max karakterden fazla olmamalıdır.',
        'array'   => ':attribute, :max öğeden fazla olmamalıdır.',
    ],
    'mimes'                => ':attribute, :values türünde bir dosya olmalıdır.',
    'mimetypes'            => ':attribute, :values türünde bir dosya olmalıdır.',
    'min'                  => [
        'numeric' => ':attribute, :min değerinden küçük olmamalıdır.',
        'file'    => ':attribute, :min kilobayttan küçük olmamalıdır.',
        'string'  => ':attribute, :min karakterden az olmamalıdır.',
        'array'   => ':attribute, :min öğeden az olmamalıdır.',
    ],
    'not_in'               => 'Seçili :attribute geçersiz.',
    'not_regex'            => ':attribute formatı geçersiz.',
    'numeric'              => ':attribute bir sayı olmalıdır.',
    'present'              => ':attribute alanı mevcut olmalıdır.',
    'regex'                => ':attribute formatı geçersiz.',
    'required'             => ':attribute alanı gereklidir.',
    'required_if'          => ':other :value ise :attribute alanı gereklidir.',
    'required_unless'      => ':other :values içinde bulunmadığı sürece :attribute alanı gereklidir.',
    'required_with'        => ':values mevcut olduğunda :attribute alanı gereklidir.',
    'required_with_all'    => ':values mevcut olduğunda :attribute alanı gereklidir.',
    'required_without'     => ':values mevcut olmadığında :attribute alanı gereklidir.',
    'required_without_all' => ':values hiçbiri mevcut değilse :attribute alanı gereklidir.',
    'same'                 => ':attribute ile :other eşleşmelidir.',
    'size'                 => [
        'numeric' => ':attribute :size olmalıdır.',
        'file'    => ':attribute :size kilobayt olmalıdır.',
        'string'  => ':attribute :size karakter olmalıdır.',
        'array'   => ':attribute :size öğe içermelidir.',
    ],
    'starts_with'          => ':attribute, şunlardan biriyle başlamalıdır: :values',
    'string'               => ':attribute bir metin olmalıdır.',
    'timezone'             => ':attribute geçerli bir saat dilimi olmalıdır.',
    'unique'               => ':attribute zaten alınmış.',
    'uploaded'             => ':attribute yüklemesi başarısız oldu.',
    'url'                  => ':attribute biçimi geçersiz.',
    'uuid'                 => ':attribute geçerli bir UUID olmalıdır.',

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

    'captcha' => ':attribute yanlış.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'name'                  => 'Ad',
        'username'              => 'Kullanıcı adı',
        'email'                 => 'E-posta',
        'first_name'            => 'Ad',
        'last_name'             => 'Soyad',
        'password'              => 'Şifre',
        'password_confirmation' => 'Şifre onayı',
        'city'                  => 'Şehir',
        'country'               => 'Ülke',
        'address'               => 'Adres',
        'phone'                 => 'Sabit telefon',
        'mobile'                => 'Cep telefonu',
        'age'                   => 'Yaş',
        'sex'                   => 'Cinsiyet',
        'gender'                => 'Cinsiyet',
        'day'                   => 'Gün',
        'month'                 => 'Ay',
        'year'                  => 'Yıl',
        'hour'                  => 'Saat',
        'minute'                => 'Dakika',
        'second'                => 'Saniye',
        'title'                 => 'Başlık',
        'text'                  => 'Metin',
        'content'               => 'İçerik',
        'description'           => 'Açıklama',
        'excerpt'               => 'Alıntı',
        'date'                  => 'Tarih',
        'time'                  => 'Zaman',
        'available'             => 'Mevcut',
        'size'                  => 'Boyut',
        'terms'                 => 'Şartlar',
        'province'              => 'İl',
        'tel'                   => 'Telefon',
        'equipment'             => 'Ekipman',
        'activity'              => 'Etkinlik',
        'groups'                => 'Gruplar',
        'website'               => 'Web sitesi',
        'info_icon'             => 'Simge',
        'info_logo'             => 'Şirket logosu',
        'image'                 => 'Resim',
        'link'                  => 'Bağlantı',
        'category_id'           => 'Kategori',
        'postcat'               => 'Blog kategorisi',
        'productcat'            => 'Ürün kategorisi',
        'province_id'           => 'İl',
        'city_id'               => 'Şehir',
        'postal_code'           => 'Posta kodu',
        'file'                  => "Dosya",
        'subject'               => "Konu",
        'message'               => "Mesaj",
        'gateway_payir_api'     => 'pay.ir API kodu',

        'gateway_mellat_username'     => 'Mellat kapı kullanıcı adı',
        'gateway_mellat_password'     => 'Mellat kapı şifresi',
        'gateway_mellat_terminalId'   => 'Mellat kapı terminal kimliği',

        'gateway'               => 'Ödeme kapısı',
        'price'                 => "Fiyat",
        'prices'                => "Fiyatlar",
        'stock'                 => "Stok",
        'color'                 => "Renk",
        'warranty'              => "Garanti",
        'cart_max'              => "Her siparişteki maksimum miktar",
        'slug'                  => 'Meta URL',
        'captcha'               => 'Güvenlik kodu',
        'specification_group'   => 'Özellik grubu',
        'spec_type'             => 'Özellik türü',
        'weight'                => 'Ağırlık',
        'type'                  => 'Tür',
        'percent'               => 'Yüzde',
        'referral_code'         => 'Yönlendirme kodu'
    ],

];
