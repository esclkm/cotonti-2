<?php
/* ====================
[BEGIN_COT_EXT]
Name=Polls
Category=module
Description=Lets the user vote for specific options
Version=0.9.1
Date=2011-08-19
Author=Neocrome & Feliz Team
Copyright=(c) Feliz Team 2008-2011
Notes=BSD License
Auth_guests=RW
Lock_guests=A
Auth_members=RW
Lock_members=
[END_COT_EXT]

[BEGIN_COT_EXT_CONFIG]
markup=01:radio::1:
ip_id_polls=02:select:ip,id:ip:
max_options_polls=03:select:5,10,20,50,100:100:
del_dup_options=04:radio::1:
maxpolls=01:select:1,2,3,4,5:1:
mode=02:select:Recent polls,Random polls:Recent polls:
[END_COT_EXT_CONFIG]
==================== */

/**
 * Polls setup file
 *
 * @package polls
 * @version 0.7.0
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2008-2014
 * @license BSD
 */
