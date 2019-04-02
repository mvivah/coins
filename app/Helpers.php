<?php
use app\User;
//Datalist function for all countries
    function getCountry() 
    { 
        $countries = array('Afghanistan','Albania','Algeria','Andorra','Angola','Antigua And Barbuda','Argentina','Armenia','Australia','Austria',
        'Azerbaijan','Bahamas','Bahrain','Bangladesh','Barbados','Belarus','Belgium','Belize','Benin','Bhutan','Bolivia','Bosnia And Herzegovina',
        'Botswana','Brazil','Brunei','Bulgaria','Burkina Faso','Burundi','Cabo Verde','Cambodia','Cameroon','Canada','Central African Republic','Chad',
        'Chile','China','Colombia','Comoros','Congo','Democratic Republic Of Congo','Costa Rica','Côte D’ivoire','Croatia','Cuba','Cyprus','Czech Republic',
        'Denmark','Djibouti','Dominica','Dominican Republic','East Timor','Ecuador','Egypt','El Salvador','Equatorial Guinea','Eritrea','Estonia','Ethiopia','Eswatini',
        'Fiji','Finland','France','Gabon','Gambia','Georgia','Germany','Ghana','Greece','Grenada','Guatemala','Guinea','Guinea-Bissau','Guyana','Haiti',
        'Honduras','Hungary','Iceland','India','Indonesia','Iran','Iraq','Ireland','Israel','Italy','Jamaica','Japan','Jordan','Kazakhstan','Kenya',
        'Kiribati','North Korea','South Korea','Kosovo','Kuwait','Kyrgyzstan','Laos','Latvia','Lebanon','Lesotho','Liberia','Libya','Liechtenstein','Lithuania',
        'Luxembourg','Macedonia','Madagascar','Malawi','Malaysia','Maldives','Mali','Malta','Marshall Islands','Mauritania','Mauritius','Mexico',
        'Micronesia','Moldova','Monaco','Mongolia','Montenegro','Morocco','Mozambique','Myanmar','Namibia','Nauru','Nepal','Netherlands',
        'Newzealand','Nicaragua','Niger','Nigeria','Norway','Oman','Pakistan','Palau','Panama','Papua','Newguinea','Paraguay','Peru',
        'Philippines','Poland','Portugal','Qatar','Romania','Russia','Rwanda','Saint Kitts And Nevis','Saint Lucia','Saint Vincent And The Grenadines','Samoa','San Marino',
        'Sao Tome And Principe','Saudi Arabia','Senegal','Serbia','Seychelles','Sierra Leone','Singapore','Slovakia','Slovenia','Solomon Islands','Somalia','South Africa',
        'Spain','Sri Lanka','Sudan','South Sudan','Suriname','Swaziland','Sweden','Switzerland','Syria','Taiwan','Tajikistan','Tanzania',
        'Thailand','Togo','Tonga','Trinidad And Tobago','Tunisia','Turkey','Turkmenistan','Tuvalu','Uganda','Ukraine','United Arab Emirates','United Kingdom',
        'United States Of America','Uruguay','Uzbekistan','Vanuatu','Vatican City','Venezuela','Vietnam','Yemen','Zambia','Zimbabwe','All Countries');
       
        for($i=0; $i<sizeof($countries); $i++)
        {
            echo '<option value="'.$countries[$i].'">';
        }
        unset($countries);
    }
    function getUsers(){
        $users = User::pluck('id','name');
        foreach($users as $user)
        {
            echo '<option value="'.$user->id.'">'.$user->id.'</option>';
        }
    }