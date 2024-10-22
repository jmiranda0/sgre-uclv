<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('countries')->insert([
            ['name' => 'United States', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Canada', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Afghanistan', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Albania', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Algeria', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'American Samoa', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Andorra', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Angola', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Anguilla', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Antarctica', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Antigua and/or Barbuda', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Argentina', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Armenia', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Aruba', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Australia', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Austria', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Azerbaijan', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Bahamas', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Bahrain', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Bangladesh', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Barbados', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Belarus', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Belgium', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Belize', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Benin', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Bermuda', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Bhutan', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Bolivia', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Bosnia and Herzegovina', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Botswana', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Bouvet Island', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Brazil', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'British lndian Ocean Territory', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Brunei Darussalam', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Bulgaria', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Burkina Faso', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Burundi', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Cambodia', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Cameroon', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Cape Verde', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Cayman Islands', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Central African Republic', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Chad', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Chile', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'China', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Christmas Island', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Cocos (Keeling) Islands', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Colombia', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Comoros', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Congo', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Cook Islands', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Costa Rica', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Croatia (Hrvatska)', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Cuba', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Cyprus', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Czech Republic', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Democratic Republic of Congo', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Denmark', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Djibouti', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Dominica', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Dominican Republic', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'East Timor', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Ecudaor', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Egypt', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'El Salvador', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Equatorial Guinea', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Eritrea', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Estonia', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Ethiopia', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Falkland Islands (Malvinas)', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Faroe Islands', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Fiji', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Finland', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'France', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'France, Metropolitan', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'French Guiana', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'French Polynesia', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'French Southern Territories', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Gabon', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Gambia', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Georgia', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Germany', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Ghana', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Gibraltar', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Greece', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Greenland', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Grenada', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Guadeloupe', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Guam', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Guatemala', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Guinea', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Guinea-Bissau', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Guyana', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Haiti', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Heard and Mc Donald Islands', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Honduras', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Hong Kong', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Hungary', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Iceland', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'India', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Indonesia', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Iran (Islamic Republic of)', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Iraq', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Ireland', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Israel', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Italy', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Ivory Coast', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Jamaica', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Japan', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Jordan', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Kazakhstan', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Kenya', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Kiribati', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Korea, Democratic People\'s Republic of', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Korea, Republic of', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Kuwait', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Kyrgyzstan', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Lao People\'s Democratic Republic', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Latvia', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Lebanon', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Lesotho', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Liberia', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Libyan Arab Jamahiriya', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Liechtenstein', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Lithuania', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Luxembourg', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Macau', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Macedonia', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Madagascar', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Malawi', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Malaysia', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Maldives', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Mali', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Malta', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Marshall Islands', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Martinique', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Mauritania', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Mauritius', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Mayotte', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Mexico', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Micronesia, Federated States of', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Moldova, Republic of', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Monaco', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Mongolia', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Montserrat', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Morocco', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Mozambique', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Myanmar', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Namibia', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Nauru', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Nepal', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Netherlands', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Netherlands Antilles', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'New Caledonia', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'New Zealand', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Nicaragua', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Niger', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Nigeria', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Niue', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Norfork Island', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Northern Mariana Islands', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Norway', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Oman', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Pakistan', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Palau', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Panama', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Papua New Guinea', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Paraguay', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Peru', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Philippines', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Pitcairn', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Poland', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Portugal', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Puerto Rico', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Qatar', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Republic of South Sudan', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Reunion', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Romania', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Russian Federation', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Rwanda', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Saint Kitts and Nevis', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Saint Lucia', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Saint Vincent and the Grenadines', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Samoa', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'San Marino', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Sao Tome and Principe', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Saudi Arabia', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Senegal', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Serbia', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Seychelles', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Sierra Leone', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Singapore', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Slovakia', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Slovenia', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Solomon Islands', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Somalia', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'South Africa', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'South Georgia South Sandwich Islands', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Spain', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Sri Lanka', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'St. Helena', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'St. Pierre and Miquelon', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Sudan', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Suriname', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Svalbarn and Jan Mayen Islands', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Swaziland', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Sweden', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Switzerland', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Syrian Arab Republic', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Taiwan', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Tajikistan', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Tanzania, United Republic of', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Thailand', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Togo', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Tokelau', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Tonga', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Trinidad and Tobago', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Tunisia', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Turkey', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Turkmenistan', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Turks and Caicos Islands', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Tuvalu', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Uganda', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Ukraine', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'United Arab Emirates', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'United Kingdom', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'United States minor outlying islands', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Uruguay', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Uzbekistan', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Vanuatu', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Vatican City State', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Venezuela', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Vietnam', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Virgin Islands (British)', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Virgin Islands (U.S.)', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Wallis and Futuna Islands', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Western Sahara', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Yemen', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Yugoslavia', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Zaire', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Zambia', 'created_at'=> now(), 'updated_at'=> now()],
			['name' => 'Zimbabwe', 'created_at'=> now(), 'updated_at'=> now()],
            
        ]);
    }
}