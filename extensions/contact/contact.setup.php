<?php
/* ====================
[BEGIN_COT_EXT]
Name=Contact
Category=forms-feedback
Description=Contact form for user feedback delivered by e-mail and recorded in database
Version=2.7.0
Date=2011-05-24
Author=Feliz Team
Copyright=&copy; Feliz Team 2008-2014
Notes=
Auth_guests=RW
Lock_guests=12345A
Auth_members=RW
Lock_members=12345A
[END_COT_EXT]

[BEGIN_COT_EXT_CONFIG]
email=01:string:::E-mail
minchars=12:string::5:Min post length, chars
map=12:text:::Map
about=13:text:::About
save=14:select:email,db,both:both:Save Method
template=15:textarea:::Email template
[END_COT_EXT_CONFIG]
==================== */

/**
 * Contact Extension for Feliz CMF
 *
 * @package contact
 * @version 2.1
 * @author Feliz Team
 * @copyright (c) Feliz Team 2008-2014
 * @license BSD
 */
