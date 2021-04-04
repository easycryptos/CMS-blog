<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['num_links'] = 2;
$config['use_page_numbers'] = TRUE;
$config['page_query_string'] = TRUE;
$config['query_string_segment'] = 'page';
$config['first_link'] = '&laquo';
$config['last_link'] = '&raquo';

$config['full_tag_open'] = "<ul class='pagination'>";
$config['full_tag_close'] = "</ul>";
$config['num_tag_open'] = '<li class="page-num">';
$config['num_tag_close'] = '</li>';
$config['cur_tag_open'] = "<li class='disabled'><li class='active page-num'><a href='#'>";
$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";

$config['next_link'] = '&rsaquo;';
$config['next_tag_open'] = "<li class='next'>";
$config['next_tagl_close'] = "</li>";

$config['prev_link'] = '&lsaquo;';
$config['prev_tag_open'] = "<li class='prev'>";
$config['prev_tagl_close'] = "</li>";

$config['first_tag_open'] = "<li class='page-first'>";
$config['first_tagl_close'] = "</li>";
$config['last_tag_open'] = "<li class='page-last'>";
$config['last_tagl_close'] = "</li>";