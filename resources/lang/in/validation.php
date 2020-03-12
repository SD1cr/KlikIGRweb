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

	"accepted"             => ":attribute harus dicentang.",
	"active_url"           => ":attribute bukan merupakan URL yang valid.",
	"after"                => ":attribute harus berupa tanggal setelah :date.",
	"alpha"                => ":attribute hanya boleh terdiri dari huruf.",
	"alpha_dash"           => ":attribute hanya boleh terdiri dari huruf, angka, dan strip.",
	"alpha_num"            => ":attribute hanya boleh terdiri dari huruf dan angka.",
	"array"                => ":attribute harus berupa sebuah array.",
	"before"               => ":attribute harus berupa tanggal sebelum :date.",
	"between"              => [
		"numeric" => ":attribute harus bernilai dari :min sampai :max.",
		"file"    => ":attribute harus bernilai dari :min sampai :max kilobyte.",
		"string"  => ":attribute harus bernilai dari :min sampai :max karakter.",
		"array"   => ":attribute harus bernilai dari :min sampai :max item.",
	],
	"boolean"              => ":attribute harus benar atau salah.",
	"confirmed"            => "konfirmasi :attribute tidak sama.",
	"date"                 => ":attribute bukan tanggal yang valid.",
	"date_format"          => ":attribute tidak sesuai format :format.",
	"different"            => ":attribute dan :other harus berbeda.",
	"digits"               => ":attribute harus :digits digit.",
	"digits_between"       => ":attribute harus diantara :min dan :max digit.",
	"email"                => ":attribute harus berupa email yang valid.",
	"filled"               => ":attribute harus diisi.",
	"exists"               => ":attribute tidak valid.",
	"image"                => ":attribute harus sebuah gambar.",
	"in"                   => ":attribute tidak valid.",
	"integer"              => ":attribute harus berupa integer.",
	"ip"                   => ":attribute harus berupa IP Address yang valid.",
	"max"                  => [
		"numeric" => ":attribute tidak boleh lebih besar dari :max.",
		"file"    => ":attribute tidak boleh lebih besar dari :max kilobyte.",
		"string"  => ":attribute tidak boleh lebih besar dari :max karakter.",
		"array"   => ":attribute tidak boleh lebih besar dari :max item.",
	],
	"mimes"                => ":attribute harus berupa file: :values.",
	"min"                  => [
		"numeric" => ":attribute harus lebih besar dari :min.",
		"file"    => ":attribute harus lebih besar dari :min kilobyte.",
		"string"  => ":attribute harus lebih besar dari :min karakter.",
		"array"   => ":attribute harus lebih besar dari :min item.",
	],
	"not_in"               => ":attribute tidak valid.",
	"numeric"              => ":attribute harus angka.",
	"regex"                => "format :attribute tidak valid.",
	"required"             => ":attribute harus diisi.",
	"required_if"          => ":attribute harus diisi jika :other = :value.",
	"required_with"        => ":attribute harus diisi jika :values diisi.",
	"required_with_all"    => ":attribute harus diisi jika semua :values diisi.",
	"required_without"     => ":attribute harus diisi jika :values tidak diisi.",
	"required_without_all" => ":attribute harus diisi jika :values tidak ada yang diisi.",
	"same"                 => ":attribute and :other must match.",
	"size"                 => [
		"numeric" => ":attribute harus :size.",
		"file"    => ":attribute harus :size kilobyte.",
		"string"  => ":attribute harus :size karakter.",
		"array"   => ":attribute harus terdiri dari :size item.",
	],
	"unique"               => "sudah ada :attribute dengan isi yang sama.",
	"url"                  => ":attribute tidak valid.",
	"timezone"             => ":attribute tidak valid.",

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
	| The following language lines are used to swap attribute place-holders
	| with something more reader friendly such as E-Mail Address instead
	| of "email". This simply helps us make messages a little cleaner.
	|
	*/

	'attributes' => [],

];
