<?php
/**
 * [vt] theme settings backport for OXID 4.9 - 4.10
 * The MIT License (MIT)
 *
 * Copyright (C) 2016  Marat Bedoev
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * Author:     Marat Bedoev <m@marat.ws>
 */

$sMetadataVersion = '1.1';
$aModule = array(
    'id'          => 'vt-themesettings',
    'title'       => '[vt] theme settings backport',
    'description' => 'backport for the new exciting OXID 6 feature: theme.php settings',
    'thumbnail'   => 'oxid-vt.jpg',
    'version'     => '0.0.1',
    'author'      => 'Marat Bedoev',
    'email'       => 'm@marat.ws',
    'url'         => 'https://github.com/vanilla-thunder/vt-themesettings',
    'extend'      => array(
       'oxtheme' => 'vt/vt-themesettings/extend/oxthemevttsb',
       'theme_config' => 'vt/vt-themesettings/extend/theme_configvttsb'
    ),
    'templates' => [
       'vt_themesettings.tpl'  => 'vt/vt-themesettings/application/views/admin/vt_themesettings.tpl'
    ]
);
