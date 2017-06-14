<?php

/**
 * importing Theme Settings from theme.php for OXID eShop
 * Copyright (C) 2017  Marat Bedoev
 * info:  m@marat.ws
 *
 * This program is free software;
 * you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation;
 * either version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with this program; if not, see <http://www.gnu.org/licenses/>
 *
 * author: Marat Bedoev
 */

$sMetadataVersion = '1.1';
$aModule = [
    'id'          => 'themesettings',
    'title'       => '[vt] theme settings',
    'description' => 'importing Theme Settings from theme.php for OXID eShop',
    'thumbnail'   => 'oxid-vt.jpg',
    'version'     => '0.0.2 2017-1-13',
    'author'      => 'Marat Bedoev',
    'email'       => 'm@marat.ws',
    'url'         => 'https://github.com/vanilla-thunder/themesettings',
    'extend'      => [
        'oxtheme'      => 'vt/themesettings/extend/oxthemevttsb',
        'theme_config' => 'vt/themesettings/extend/theme_configvttsb'
    ],
    'templates'   => [
        'vt_themesettings.tpl' => 'vt/themesettings/application/views/admin/vt_themesettings.tpl'
    ]
];
