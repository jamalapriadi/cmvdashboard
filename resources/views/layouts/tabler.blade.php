<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <!-- GOOGLE FONTS -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,500,500i,600,600i,700,700i&amp;subset=latin-ext">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
  {{Html::style('limitless1/assets/css/icons/icomoon/styles.css')}}
  
  <script src="{{URL::asset('limitless1/assets/js/core/libraries/jquery.min.js')}}"></script>
  <script src="{{URL::asset('tabler/assets/js/vendors/bootstrap.bundle.min.js')}}"></script>
  <script src="{{URL::asset('tabler/assets/js/vendors/jquery.sparkline.min.js')}}"></script>
  <script src="{{URL::asset('tabler/assets/js/vendors/selectize.min.js')}}"></script>
  <script src="{{URL::asset('tabler/assets/js/vendors/jquery.tablesorter.min.js')}}"></script>
  <script src="{{URL::asset('tabler/assets/js/vendors/jquery-jvectormap-2.0.3.min.js')}}"></script>
  <script src="{{URL::asset('tabler/assets/js/vendors/jquery-jvectormap-de-merc.js')}}"></script>
  <script src="{{URL::asset('tabler/assets/js/vendors/jquery-jvectormap-world-mill.js')}}"></script>
  <script src="{{URL::asset('tabler/assets/js/vendors/circle-progress.min.js')}}"></script>

  <!--DATATABLE AND CKEDITOR -->
  {{Html::script('limitless1/ckeditor/ckeditor.js')}}

  <!-- Theme JS files -->
  {{Html::script('limitless1/assets/js/plugins/tables/datatables/datatables.min.js')}}
  {{Html::script('limitless1/assets/js/plugins/tables/datatables/extensions/col_vis.min.js')}}
  {{Html::script('limitless1/assets/js/plugins/forms/styling/uniform.min.js')}}
  {{Html::script('limitless1/assets/js/core/libraries/jquery_ui/interactions.min.js')}}
  {{Html::script('limitless1/assets/js/plugins/forms/selects/select2.min.js')}}
  {{Html::script('limitless1/assets/js/plugins/notifications/pnotify.min.js')}}
  {{Html::script('limitless1/assets/js/plugins/forms/styling/switchery.min.js')}}
  {{Html::script('limitless1/assets/js/plugins/forms/styling/switch.min.js')}}

  {{Html::style('limitless1/assets/js/plugins/sweetalert/dist/sweetalert.css')}}
  {{Html::script('limitless1/assets/js/plugins/sweetalert/dist/sweetalert.min.js')}}
  
  <!-- Dashboard Core -->
  <link href="{{URL::asset('tabler/assets/css/dashboard.css')}}" rel="stylesheet" />
  <style>
    /* ------------------------------------------------------------------------------
    *
    *  # Select2 selects
    *
    *  Styles for select2.js - custom select plugin
    *
    *  Version: 1.0
    *  Latest update: May 25, 2015
    *
    * ---------------------------------------------------------------------------- */
    /* # Single select
    -------------------------------------------------- */
    .select2-container {
      width: 100%;
      outline: 0;
      position: relative;
      display: inline-block;
      vertical-align: middle;
      color: #333333;
      text-align: left;
      border-radius: 3px;
    }
    .select2-container[class*=border-] .select2-choice,
    .select2-container[class*=border-].select2-dropdown-open.select2-drop-above .select2-choice,
    .select2-container[class*=border-].select2-dropdown-open.select2-drop-above .select2-choices {
      border-color: inherit;
    }
    .select2-container.border-lg .select2-choice,
    .select2-container.border-lg .select2-choices {
      border-width: 2px;
    }
    .select2-container[class*=bg-] .select2-choice {
      background-color: inherit;
      border-color: inherit;
      color: #fff;
    }
    .select2-container[class*=bg-] .select2-choice:hover,
    .select2-container[class*=bg-].select2-dropdown-open .select2-choice {
      -webkit-box-shadow: 0 0 0 100px rgba(0, 0, 0, 0.05) inset;
      box-shadow: 0 0 0 100px rgba(0, 0, 0, 0.05) inset;
    }
    .select2-container[class*=bg-].select2-container-disabled .select2-choice {
      -webkit-box-shadow: none;
      box-shadow: none;
    }
    .select2-container.select2-container-disabled .select2-choice {
      cursor: not-allowed;
      background-color: #fafafa;
      color: #999999;
      -webkit-box-shadow: none;
      box-shadow: none;
    }
    .select2-container.select2-container-disabled .select2-choice abbr {
      cursor: not-allowed;
    }
    .select2-container.select2-container-disabled[class*=bg-] {
      border-color: rgba(255, 255, 255, 0.4);
    }
    .select2-container.select2-container-disabled[class*=bg-] .select2-choice {
      background-color: rgba(255, 255, 255, 0.4);
      color: rgba(255, 255, 255, 0.8);
    }
    .select2-choice {
      display: block;
      background-color: #fff;
      height: 36px;
      padding: 7px 12px;
      padding-left: 11px;
      padding-right: 0;
      line-height: 1.5384616;
      position: relative;
      border: 1px solid #dddddd;
      white-space: nowrap;
      border-radius: 3px;
      background-clip: padding-box;
      -webkit-touch-callout: none;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
    }
    .select2-choice,
    .select2-choice:hover,
    .select2-choice:focus {
      color: #333333;
    }
    .select2-choice:hover {
      -webkit-box-shadow: 0 0 0 100px rgba(0, 0, 0, 0.01) inset;
      box-shadow: 0 0 0 100px rgba(0, 0, 0, 0.01) inset;
    }
    .select2-dropdown-open .select2-choice {
      border-radius: 3px 3px 0 0;
      -webkit-box-shadow: 0 0 0 100px rgba(0, 0, 0, 0.02) inset;
      box-shadow: 0 0 0 100px rgba(0, 0, 0, 0.02) inset;
    }
    .select2-drop-above .select2-choice {
      border-radius: 0 0 3px 3px;
    }
    .select2-choice .select2-chosen {
      margin-right: 28px;
      padding-left: 1px;
      display: block;
      overflow: hidden;
      white-space: nowrap;
      text-overflow: ellipsis;
      float: none;
      width: auto;
    }
    .select2-choice .select2-chosen > i {
      margin-right: 10px;
    }
    .select2-choice .select2-chosen > i.icon-undefined {
      margin-right: 0;
    }
    .select2-choice abbr {
      display: none;
      position: absolute;
      right: 9px;
      top: 50%;
      margin-top: -8px;
      border: 0;
      cursor: pointer;
      outline: 0;
      border-radius: 3px;
      line-height: 1;
      opacity: 0.8;
      filter: alpha(opacity=80);
    }
    .select2-choice abbr:hover {
      opacity: 1;
    }
    .select2-choice abbr:after {
      content: '\ed6b';
      font-family: 'icomoon';
      display: inline-block;
      font-size: 16px;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
    }
    .select2-container[class*=bg-] .select2-choice abbr,
    .select2-container[class*=bg-] .select2-choice abbr:hover {
      color: #fff;
    }
    .select2-allowclear .select2-choice abbr {
      display: inline-block;
    }
    .select2-choice .select2-arrow:after {
      content: '\e9c5';
      font-family: 'Icomoon';
      display: inline-block;
      position: absolute;
      top: 50%;
      right: 12px;
      width: 16px;
      text-align: right;
      margin-top: -8px;
      font-size: 16px;
      line-height: 1;
      color: inherit;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
    }
    .select2-dropdown-open .select2-choice .select2-arrow:after {
      content: '\e9c6';
    }
    .select2-allowclear .select2-choice .select2-arrow:after {
      content: none;
    }
    .select2-drop-mask {
      border: 0;
      margin: 0;
      padding: 0;
      position: fixed;
      left: 0;
      top: 0;
      min-height: 100%;
      min-width: 100%;
      height: auto;
      width: auto;
      z-index: 9998;
      background-color: #fff;
      opacity: 0;
      filter: alpha(opacity=0);
    }
    .select2-drop {
      width: 100%;
      position: absolute;
      z-index: 9999;
      top: 100%;
      background-color: #fff;
      color: #333333;
      border: 1px solid #dddddd;
      border-top-width: 0;
      border-radius: 0 0 3px 3px;
    }
    .select2-drop-above {
      border-top-width: 1px;
      border-bottom-width: 0;
      border-radius: 3px 3px 0 0;
    }
    .select2-drop-active {
      border-radius: 0 0 3px 3px;
    }
    .select2-drop.select2-drop-above.select2-drop-active {
      border-radius: 3px 3px 0 0;
    }
    .select2-drop-auto-width {
      width: auto;
    }
    .select2-hidden-accessible {
      border: 0;
      clip: rect(0 0 0 0);
      height: 1px;
      margin: -1px;
      overflow: hidden;
      padding: 0;
      position: absolute;
      width: 1px;
    }
    .select2-search {
      display: block;
      width: 100%;
      margin: 0;
      padding: 12px;
      padding-bottom: 7px;
      position: relative;
      z-index: 10000;
      white-space: nowrap;
    }
    .select2-search:after {
      content: '\e98e';
      font-family: 'icomoon';
      position: absolute;
      top: 50%;
      left: 24px;
      color: inherit;
      display: block;
      font-size: 12px;
      margin-top: -4px;
      line-height: 1;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
      opacity: 0.6;
      filter: alpha(opacity=60);
    }
    .select2-search input {
      width: 100%;
      height: 36px;
      padding: 7px 12px;
      padding-left: 36px;
      border-radius: 3px;
      border: 1px solid #dddddd;
      outline: 0;
    }
    .select2-drop[class*=bg-] .select2-search input {
      background-color: rgba(0, 0, 0, 0.2);
      border-color: transparent;
      color: #fff;
    }
    .select2-results {
      max-height: 250px;
      margin: 0;
      padding: 5px 0;
      position: relative;
      overflow-x: hidden;
      overflow-y: auto;
      -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
    }
    .select2-results .select2-result-sub {
      margin: 0;
      padding-left: 0;
    }
    .select2-results li {
      list-style: none;
      display: list-item;
    }
    .select2-results li em {
      font-style: normal;
    }
    .select2-results li.select2-result-with-children > .select2-result-label {
      font-size: 11px;
      line-height: 1.82;
      text-transform: uppercase;
      cursor: default;
      font-weight: 500;
      margin-top: 2px;
      margin-bottom: 2px;
    }
    .select2-results li.select2-result-with-children:first-child > .select2-result-label {
      margin-top: 0;
    }
    .select2-results li.select2-result-with-children .select2-result > .select2-result-label {
      padding-left: 24px;
      padding-right: 24px;
    }
    .select2-results .select2-more-results {
      background: #f8f8f8;
      display: list-item;
    }
    .select2-results .select2-result-label {
      padding: 7px 12px;
      margin: 0;
      position: relative;
      cursor: pointer;
      -webkit-touch-callout: none;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
    }
    .select2-results .select2-result-label > i {
      margin-right: 10px;
    }
    .select2-results .select2-result-label > i.icon-undefined {
      display: none;
    }
    .select2-results .select2-result-label > span {
      left: 10px;
    }
    .select2-results .select2-highlighted {
      background-color: #f5f5f5;
    }
    .select2-results .select2-highlighted ul {
      background-color: #fff;
      color: #333333;
    }
    .select2-results .select2-highlighted em {
      background-color: transparent;
    }
    .select2-drop[class*=bg-] .select2-results .select2-highlighted {
      background-color: rgba(0, 0, 0, 0.1);
    }
    .select2-results .select2-no-results,
    .select2-results .select2-searching,
    .select2-results .select2-selection-limit {
      background-color: #f8f8f8;
      padding: 7px 12px;
      color: #999999;
      border-top: 1px solid #dddddd;
      margin-bottom: -5px;
      border-radius: 0;
    }
    .select2-drop[class*=bg-] .select2-results .select2-no-results,
    .select2-drop[class*=bg-] .select2-results .select2-searching,
    .select2-drop[class*=bg-] .select2-results .select2-selection-limit {
      background-color: rgba(0, 0, 0, 0.1);
      border-color: rgba(255, 255, 255, 0.1);
      color: #fff;
    }
    .select2-results .select2-disabled {
      color: #999999;
      display: list-item;
    }
    .select2-results .select2-disabled .select2-result-label {
      cursor: not-allowed;
    }
    .select2-drop[class*=bg-] .select2-results .select2-disabled {
      color: #fff;
      opacity: 0.5;
      filter: alpha(opacity=50);
    }
    .select2-results .select2-selected {
      display: none;
    }
    .select2-results ul ul > li .select2-result-label {
      padding-left: 24px;
    }
    .select2-results ul ul ul > li .select2-result-label {
      padding-left: 36px;
    }
    .select2-results ul ul ul ul > li .select2-result-label {
      padding-left: 48px;
    }
    .select2-results ul ul ul ul ul > li .select2-result-label {
      padding-left: 60px;
    }
    .select2-results ul ul ul ul ul ul > li .select2-result-label {
      padding-left: 72px;
    }
    .select2-results ul ul ul ul ul ul ul > li .select2-result-label {
      padding-left: 84px;
    }
    /* # Multiple select
    -------------------------------------------------- */
    .select2-container-multi .select2-choices {
      margin: 0;
      border-radius: 3px;
      padding: 0 0 3px 0;
      position: relative;
      outline: 0;
      border: 1px solid #dddddd;
      cursor: text;
      overflow: hidden;
      background-color: #fff;
    }
    .select2-container-multi .select2-choices:after {
      content: '';
      display: table;
      clear: both;
    }
    .select2-container-multi .select2-choices li {
      float: left;
      list-style: none;
    }
    .select2-container-multi .select2-choices.ui-sortable > li {
      cursor: move;
    }
    .select2-container-multi .select2-choices .select2-search-field {
      margin: 0;
      padding: 0;
      white-space: nowrap;
    }
    .select2-container-multi .select2-choices .select2-search-field input {
      padding: 7px 12px;
      margin-top: 3px;
      color: #333333;
      outline: 0;
      border: 0;
      background: transparent !important;
    }
    .select2-container-multi .select2-choices .select2-search-choice {
      margin: 3px 0 0 3px;
      position: relative;
      cursor: default;
      background-clip: padding-box;
      -webkit-touch-callout: none;
      border-radius: 3px;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
    }
    html[dir="rtl"] .select2-container-multi .select2-choices .select2-search-choice {
      margin-left: 0;
      margin-right: 3px;
    }
    .select2-container-multi .select2-choices .select2-search-choice > div {
      border-radius: 3px;
      color: #fff;
      padding: 7px 12px;
      padding-right: 30px;
      background-color: #455a64;
    }
    .select2-container-multi .select2-choices .select2-search-choice > div > i {
      margin-right: 10px;
    }
    .select2-container-multi .select2-choices .select2-search-choice.select2-locked > div {
      padding: 7px 12px;
    }
    .select2-container-multi .select2-choices .select2-search-choice[class*=bg-] > div {
      background-color: inherit;
    }
    .select2-container-multi .select2-choices .select2-search-choice .select2-chosen {
      cursor: default;
    }
    .select2-container-multi .select2-choices .select2-search-choice-close {
      position: absolute;
      right: 9px;
      top: 50%;
      margin-top: -8px;
      line-height: 1;
      opacity: 0.6;
      filter: alpha(opacity=60);
    }
    .select2-container-multi .select2-choices .select2-search-choice-close:hover {
      opacity: 1;
      filter: alpha(opacity=100);
    }
    html[dir="rtl"] .select2-container-multi .select2-choices .select2-search-choice-close {
      right: auto;
      left: 6px;
    }
    .select2-container-multi .select2-choices .select2-search-choice-close:after {
      content: '\ed6b';
      font-family: 'icomoon';
      display: block;
      font-size: 16px;
      color: #fff;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
    }
    .select2-container-multi[class*=bg-] .select2-choices {
      background-color: inherit;
      border-color: inherit;
    }
    .select2-container-multi[class*=bg-] .select2-choices .select2-search-choice > div {
      background-color: rgba(0, 0, 0, 0.3);
    }
    .select2-container-multi[class*=border-] .select2-choices {
      border-color: inherit;
    }
    .select2-container-multi.select2-dropdown-open .select2-choices {
      border-radius: 3px 3px 0 0;
    }
    .select2-container-multi.select2-dropdown-open.select2-drop-above .select2-choices {
      border-radius: 0 0 3px 3px;
    }
    .select2-container-multi .select2-default,
    .select2-container-multi .select2-default:hover,
    .select2-container-multi .select2-default:focus {
      color: #999;
    }
    .select2-container-multi .select2-default .select2-arrow,
    .select2-container-multi .select2-default:hover .select2-arrow,
    .select2-container-multi .select2-default:focus .select2-arrow {
      color: #333333;
    }
    .select2-container-multi.select2-container-disabled .select2-choices {
      cursor: default;
      background-color: #f8f8f8;
    }
    .select2-container-multi.select2-container-disabled .select2-choices .select2-search-choice {
      color: #fff;
      opacity: 0.6;
      filter: alpha(opacity=60);
    }
    .select2-container-multi.select2-container-disabled .select2-choices .select2-search-choice > div {
      padding-right: 12px;
    }
    .select2-container-multi.select2-container-disabled .select2-choices .select2-search-choice .select2-search-choice-close {
      display: none;
    }
    /* # Additional sizing
    -------------------------------------------------- */
    .select-lg .select2-choice {
      height: 40px;
      padding: 9px 15px;
      padding-right: 0;
      font-size: 14px;
    }
    .select-lg .select2-choice abbr,
    .select-lg .select2-choice .select2-arrow:after {
      right: 15px;
    }
    .select-lg.select2-container-multi .select2-choices .select2-search-choice > div {
      padding: 9px 15px;
      padding-right: 37.5px;
      font-size: 14px;
    }
    .select-lg.select2-container-multi .select2-choices .select2-search-choice-close {
      right: 12px;
    }
    html[dir="rtl"] .select-lg.select2-container-multi .select2-choices .select2-search-choice-close {
      right: auto;
      left: 12px;
    }
    .select-lg.select2-container-multi .select2-choices .select2-search-field input {
      padding: 9px 15px;
    }
    .select-sm .select2-choice {
      height: 34px;
      padding: 6px 11px;
      padding-right: 0;
    }
    .select-sm .select2-choice abbr,
    .select-sm .select2-choice .select2-arrow:after {
      right: 11px;
    }
    .select-sm.select2-container-multi .select2-choices .select2-search-choice > div {
      padding: 6px 11px;
      padding-right: 27.5px;
    }
    .select-sm.select2-container-multi .select2-choices .select2-search-choice-close {
      right: 8px;
    }
    html[dir="rtl"] .select-sm.select2-container-multi .select2-choices .select2-search-choice-close {
      right: auto;
      left: 8px;
    }
    .select-sm.select2-container-multi .select2-choices .select2-search-field input {
      padding: 6px 11px;
    }
    .select-xs .select2-choice {
      height: 32px;
      padding: 5px 10px;
      padding-right: 0;
      font-size: 12px;
      line-height: 1.6666667;
    }
    .select-xs .select2-choice abbr,
    .select-xs .select2-choice .select2-arrow:after {
      right: 10px;
    }
    .select-xs.select2-container-multi .select2-choices .select2-search-choice > div {
      padding: 5px 10px;
      padding-right: 25px;
      font-size: 12px;
    }
    .select-xs.select2-container-multi .select2-choices .select2-search-choice-close {
      right: 7px;
    }
    html[dir="rtl"] .select-xs.select2-container-multi .select2-choices .select2-search-choice-close {
      right: auto;
      left: 7px;
    }
    .select-xs.select2-container-multi .select2-choices .select2-search-field input {
      padding: 5px 10px;
      font-size: 12px;
    }
    /* # Other Select2 styles
    -------------------------------------------------- */
    .select2-result-selectable .select2-match,
    .select2-result-unselectable .select2-match {
      text-decoration: underline;
    }
    .select2-offscreen,
    .select2-offscreen:focus {
      clip: rect(0 0 0 0) !important;
      width: 1px !important;
      height: 1px !important;
      border: 0 !important;
      margin: 0 !important;
      padding: 0 !important;
      overflow: hidden !important;
      position: absolute !important;
      outline: 0 !important;
      left: 0px !important;
      top: 0px !important;
    }
    .select2-display-none {
      display: none;
    }
    .select2-measure-scrollbar {
      position: absolute;
      top: -10000px;
      left: -10000px;
      width: 100px;
      height: 100px;
      overflow: scroll;
    }
    .movie-title {
      font-size: 15px;
      font-weight: 500;
    }
    .movie-image img {
      margin-right: 12px;
    }

    /* ------------------------------------------------------------------------------
    *
    *  # Datatables library
    *
    *  Add advanced interaction controls to any HTML table
    *
    *  Version: 1.0
    *  Latest update: May 25, 2015
    *
    * ---------------------------------------------------------------------------- */
    .dataTable {
      margin: 0;
      max-width: none;
    }
    .dataTable thead th,
    .dataTable thead td {
      outline: 0;
      position: relative;
    }
    .dataTable thead .sorting_asc,
    .dataTable thead .sorting_desc,
    .dataTable thead .sorting {
      cursor: pointer;
    }
    .dataTable thead .sorting,
    .dataTable thead .sorting_asc,
    .dataTable thead .sorting_desc,
    .dataTable thead .sorting_asc_disabled,
    .dataTable thead .sorting_desc_disabled {
      padding-right: 40px;
    }
    .dataTable thead .sorting:before,
    .dataTable thead .sorting:after,
    .dataTable thead .sorting_asc:after,
    .dataTable thead .sorting_desc:after,
    .dataTable thead .sorting_asc_disabled:after,
    .dataTable thead .sorting_desc_disabled:after {
      content: '';
      font-family: 'icomoon';
      position: absolute;
      top: 50%;
      right: 20px;
      font-size: 12px;
      margin-top: -6px;
      display: inline-block;
      line-height: 1;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
    }
    .dataTable thead .sorting:before {
      content: '\e9c1';
      margin-top: -2px;
      color: #999999;
    }
    .dataTable thead .sorting:after {
      content: '\e9c2';
      margin-top: -10px;
      color: #999999;
    }
    .dataTable thead .sorting_asc:after {
      content: '\e9c2';
    }
    .dataTable thead .sorting_desc:after {
      content: '\e9c1';
    }
    .dataTable thead .sorting_asc_disabled:after {
      content: '\e9c2';
      color: #ccc;
    }
    .dataTable thead .sorting_desc_disabled:after {
      content: '\e9c1';
      color: #ccc;
    }
    .dataTable .dataTables_empty {
      text-align: center;
    }
    .dataTables_wrapper {
      position: relative;
      clear: both;
    }
    .dataTables_wrapper:after {
      visibility: hidden;
      display: block;
      content: "";
      clear: both;
      height: 0;
    }
    .dataTables_wrapper .table-bordered {
      border-top: 0;
    }
    .dataTables_processing {
      position: absolute;
      top: 50%;
      left: 50%;
      width: 100%;
      height: 40px;
      margin-left: -50%;
      margin-top: -25px;
      padding-top: 20px;
      text-align: center;
      background-color: #fff;
      background: -webkit-gradient(linear, left top, right top, color-stop(0%, rgba(255, 255, 255, 0)), color-stop(25%, rgba(255, 255, 255, 0.9)), color-stop(75%, rgba(255, 255, 255, 0.9)), color-stop(100%, rgba(255, 255, 255, 0)));
      background: -webkit-linear-gradient(left, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.9) 25%, rgba(255, 255, 255, 0.9) 75%, rgba(255, 255, 255, 0) 100%);
      background: -moz-linear-gradient(left, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.9) 25%, rgba(255, 255, 255, 0.9) 75%, rgba(255, 255, 255, 0) 100%);
      background: -ms-linear-gradient(left, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.9) 25%, rgba(255, 255, 255, 0.9) 75%, rgba(255, 255, 255, 0) 100%);
      background: -o-linear-gradient(left, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.9) 25%, rgba(255, 255, 255, 0.9) 75%, rgba(255, 255, 255, 0) 100%);
      background: linear-gradient(to right, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.9) 25%, rgba(255, 255, 255, 0.9) 75%, rgba(255, 255, 255, 0) 100%);
    }
    .datatable-header,
    .datatable-footer {
      padding-top: 20px;
    }
    .datatable-header:after,
    .datatable-footer:after {
      content: "";
      display: table;
      clear: both;
    }
    .datatable-header > div:first-child,
    .datatable-footer > div:first-child {
      margin-left: 0;
    }
    .panel > .dataTables_wrapper .datatable-header,
    .panel > .dataTables_wrapper .datatable-footer {
      padding-left: 20px;
      padding-right: 20px;
    }
    .datatable-header {
      border-bottom: 1px solid #dddddd;
    }
    .datatable-footer {
      border-top: 1px solid #bbbbbb;
    }
    .dataTables_length {
      float: right;
      display: inline-block;
      margin: 0 0 20px 20px;
    }
    .dataTables_length > label {
      margin-bottom: 0;
    }
    .dataTables_length > label > span {
      float: left;
      margin: 8px 15px;
      margin-left: 0;
    }
    .length-left .dataTables_length {
      float: left;
    }
    .dataTables_length .select2-container {
      width: auto;
    }
    .dataTables_length .select2-choice {
      min-width: 60px;
    }
    .dataTables_filter {
      position: relative;
      display: block;
      float: left;
      margin: 0 0 20px 20px;
    }
    .dataTables_filter > label {
      margin-bottom: 0;
      position: relative;
    }
    .dataTables_filter > label:after {
      content: "\e98e";
      font-family: 'icomoon';
      font-size: 12px;
      display: inline-block;
      position: absolute;
      top: 12px;
      right: 12px;
      color: #999999;
      line-height: 1;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
    }
    .dataTables_filter > label > span {
      float: left;
      margin: 8px 15px;
      margin-left: 0;
    }
    .dataTables_filter input {
      outline: 0;
      width: 200px;
      height: 36px;
      padding: 7px 12px;
      padding-right: 34px;
      font-size: 13px;
      line-height: 1.5384616;
      color: #333333;
      background-color: #ffffff;
      border: 1px solid #dddddd;
      border-radius: 3px;
    }
    .filter-right .dataTables_filter {
      float: right;
    }
    .dataTables_info {
      float: left;
      padding: 8px 0;
      margin-bottom: 20px;
    }
    .info-right .dataTables_info {
      float: right;
    }
    .dataTables_paginate {
      float: right;
      text-align: right;
      margin: 0 0 20px 20px;
    }
    .dataTables_paginate .paginate_button {
      display: inline-block;
      padding: 7px 12px;
      min-width: 36px;
      margin-left: 2px;
      text-align: center;
      text-decoration: none;
      cursor: pointer;
      color: #333333;
      border: 1px solid transparent;
      border-radius: 3px;
    }
    .dataTables_paginate .paginate_button:first-child {
      margin-left: 0;
    }
    .dataTables_paginate .paginate_button:hover,
    .dataTables_paginate .paginate_button:focus {
      background-color: #f5f5f5;
    }
    .dataTables_paginate .paginate_button.current,
    .dataTables_paginate .paginate_button.current:hover,
    .dataTables_paginate .paginate_button.current:focus {
      color: #fff;
      background-color: #455a64;
    }
    .dataTables_paginate .paginate_button.disabled,
    .dataTables_paginate .paginate_button.disabled:hover,
    .dataTables_paginate .paginate_button.disabled:focus {
      cursor: default;
      background-color: transparent;
      color: #bbbbbb;
    }
    .paginate-left .dataTables_paginate {
      float: left;
    }
    .paging_simple .paginate_button:hover,
    .paging_simple .paginate_button:focus {
      color: #fff;
      background-color: #455a64;
    }
    .dataTables_scroll {
      clear: both;
    }
    .dataTables_scroll .dataTables_scrollHead table {
      border-bottom: 0;
    }
    .dataTables_scroll .dataTables_scrollHead th,
    .dataTables_scroll .dataTables_scrollHead td {
      white-space: nowrap;
    }
    .dataTables_scroll .dataTables_scrollBody {
      -webkit-overflow-scrolling: touch;
    }
    .dataTables_scroll .dataTables_scrollBody table {
      border-bottom: 0;
    }
    .dataTables_scroll .dataTables_scrollBody table thead th[class*=sorting]:before,
    .dataTables_scroll .dataTables_scrollBody table thead th[class*=sorting]:after {
      content: none;
    }
    .dataTables_scroll .dataTables_scrollBody table tbody tr:first-child > td {
      border-top: 0;
    }
    .dataTables_scroll .dataTables_scrollBody th,
    .dataTables_scroll .dataTables_scrollBody td {
      white-space: nowrap;
    }
    .dataTables_scroll .dataTables_scrollBody th > .dataTables_sizing,
    .dataTables_scroll .dataTables_scrollBody td > .dataTables_sizing {
      height: 0;
      overflow: hidden;
      margin: 0;
      padding: 0;
    }
    .panel-body + .dataTables_wrapper {
      border-top: 1px solid #dddddd;
    }
    .panel-body > .dataTables_wrapper .datatable-footer .dataTables_length,
    .panel-body > .dataTables_wrapper .datatable-footer .dataTables_filter,
    .panel-body > .dataTables_wrapper .datatable-footer .dataTables_info,
    .panel-body > .dataTables_wrapper .datatable-footer .dataTables_paginate {
      margin-bottom: 0;
    }
    .panel-flat > .panel-heading + .dataTables_wrapper {
      border-top: 1px solid #dddddd;
    }
    .panel > .dataTables_wrapper .table-bordered {
      border: 0;
    }
    .panel > .dataTables_wrapper .table-bordered > thead > tr > td:first-child,
    .panel > .dataTables_wrapper .table-bordered > tbody > tr > td:first-child,
    .panel > .dataTables_wrapper .table-bordered > tfoot > tr > td:first-child,
    .panel > .dataTables_wrapper .table-bordered > thead > tr > th:first-child,
    .panel > .dataTables_wrapper .table-bordered > tbody > tr > th:first-child,
    .panel > .dataTables_wrapper .table-bordered > tfoot > tr > th:first-child {
      border-left: 0;
    }
    .panel > .dataTables_wrapper .table-bordered > thead > tr > td:last-child,
    .panel > .dataTables_wrapper .table-bordered > tbody > tr > td:last-child,
    .panel > .dataTables_wrapper .table-bordered > tfoot > tr > td:last-child,
    .panel > .dataTables_wrapper .table-bordered > thead > tr > th:last-child,
    .panel > .dataTables_wrapper .table-bordered > tbody > tr > th:last-child,
    .panel > .dataTables_wrapper .table-bordered > tfoot > tr > th:last-child {
      border-right: 0;
    }
    .panel > .dataTables_wrapper .table-bordered > tbody > tr:last-child > th,
    .panel > .dataTables_wrapper .table-bordered > tbody > tr:last-child > td {
      border-bottom: 0;
    }
    .datatable-scroll-lg,
    .datatable-scroll,
    .datatable-scroll-sm {
      min-height: .01%;
    }
    .datatable-scroll-wrap {
      width: 100%;
      overflow-x: scroll;
    }
    @media (max-width: 768px) {
      .datatable-scroll-sm {
        width: 100%;
        overflow-x: scroll;
      }
      .datatable-scroll-sm th,
      .datatable-scroll-sm td {
        white-space: nowrap;
      }
    }
    @media (max-width: 1024px) {
      .datatable-scroll {
        width: 100%;
        overflow-x: scroll;
      }
      .datatable-scroll th,
      .datatable-scroll td {
        white-space: nowrap;
      }
    }
    @media (max-width: 1199px) {
      .datatable-scroll-lg {
        width: 100%;
        overflow-x: scroll;
      }
      .datatable-scroll-lg th,
      .datatable-scroll-lg td {
        white-space: nowrap;
      }
    }
    @media (max-width: 768px) {
      .dataTables_info,
      .dataTables_paginate,
      .dataTables_length,
      .dataTables_filter,
      .DTTT_container,
      .ColVis {
        float: none!important;
        text-align: center;
        margin-left: 0;
      }
      .dataTables_info,
      .dataTables_paginate {
        margin-top: 0;
      }
      .datatable-header {
        text-align: center;
      }
    }
    /* ------------------------------------------------------------------------------
    *
    *  # Columns reorder
    *
    *  Easily modify the column order of a table through drop-and-drag of column headers
    *
    *  Version: 1.0
    *  Latest update: May 25, 2015
    *
    * ---------------------------------------------------------------------------- */
    .DTCR_clonedTable {
      background-color: rgba(255, 255, 255, 0.8);
      z-index: 202;
      cursor: move;
    }
    .DTCR_clonedTable th,
    .DTCR_clonedTable td {
      border: 1px solid #dddddd !important;
    }
    .DTCR_pointer {
      width: 1px;
      background-color: #2196f3;
      z-index: 201;
    }
    /* ------------------------------------------------------------------------------
    *
    *  # Fixed columns
    *
    *  Extension that "freezes" in place the left most columns in a scrolling DataTable
    *
    *  Version: 1.0
    *  Latest update: May 25, 2015
    *
    * ---------------------------------------------------------------------------- */
    .DTFC_Cloned {
      background-color: #fff;
      border-bottom: 0;
    }
    .DTFC_LeftWrapper .DTFC_Cloned.table {
      border-right: 1px solid #dddddd;
    }
    .DTFC_RightWrapper .DTFC_Cloned.table {
      border-left: 1px solid #dddddd;
    }
    .DTFC_LeftBodyWrapper .DTFC_Cloned thead th:before,
    .DTFC_RightBodyWrapper .DTFC_Cloned thead th:before,
    .DTFC_LeftBodyWrapper .DTFC_Cloned thead th:after,
    .DTFC_RightBodyWrapper .DTFC_Cloned thead th:after {
      content: none;
    }
    .DTFC_LeftBodyWrapper .DTFC_Cloned tbody > tr:first-child > td,
    .DTFC_RightBodyWrapper .DTFC_Cloned tbody > tr:first-child > td,
    .DTFC_LeftBodyWrapper .DTFC_Cloned tbody > tr:first-child > th,
    .DTFC_RightBodyWrapper .DTFC_Cloned tbody > tr:first-child > th {
      border-top: 0;
    }
    .DTFC_Blocker {
      background-color: white;
    }
    @media (max-width: 768px) {
      .DTFC_LeftWrapper,
      .DTFC_RightWrapper {
        display: none;
      }
    }
    /* ------------------------------------------------------------------------------
    *
    *  # Columns visibility
    *
    *  Extensions allows the end user to enable or disable table column visibility
    *
    *  Version: 1.0
    *  Latest update: May 25, 2015
    *
    * ---------------------------------------------------------------------------- */
    .ColVis {
      float: right;
      margin: 0 0 20px 20px;
    }
    .colvis-left .ColVis {
      float: left;
    }
    .ColVis_catcher {
      position: absolute;
      z-index: 1101;
    }
    .ColVis_Button {
      position: relative;
      outline: 0;
    }
    .ColVis_collectionBackground {
      position: fixed;
      top: 0;
      left: 0;
      height: 100%;
      width: 100%;
      background-color: #333;
      z-index: 1100;
    }
    .ColVis_collection {
      list-style: none;
      min-width: 180px;
      padding: 5px 0;
      border: 1px solid #dddddd;
      background-color: #ffffff;
      overflow: hidden;
      z-index: 2002;
      border-radius: 3px;
      -webkit-box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }
    .ColVis_collection li {
      position: relative;
      padding: 8px 15px;
      display: block;
      cursor: pointer;
    }
    .ColVis_collection li:hover {
      color: #333333;
      background-color: #f5f5f5;
    }
    .ColVis_collection li > label {
      padding-left: 28px;
      position: relative;
      cursor: pointer;
      margin-bottom: 0;
    }
    .ColVis_collection :not(.ColVis_Special) + .ColVis_Special {
      margin-top: 10px;
    }
    .ColVis_collection :not(.ColVis_Special) + .ColVis_Special:before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      height: 1px;
      display: inline-block;
      width: 100%;
      background-color: #e5e5e5;
      margin-top: -5px;
    }
    .ColVis_collection .checker,
    .ColVis_collection .choice {
      position: absolute;
      left: 0;
      top: 1px;
    }
    @media (max-width: 768px) {
      .ColVis_collection {
        width: 100%;
        border-radius: 0;
        left: 0 !important;
      }
    }
  </style>

  @yield('css')
</head>
<body class="">
    <div class="page">
      <div class="page-main">
        <div class="header py-4">
          <div class="container">
            <div class="d-flex">
              <a class="header-brand" href="./index.html">
                <img src="./demo/brand/tabler.svg" class="header-brand-img" alt="tabler logo">
              </a>
              <div class="d-flex order-lg-2 ml-auto">
                <div class="dropdown d-none d-md-flex">
                  <a class="nav-link icon" data-toggle="dropdown">
                    <i class="fe fe-bell"></i>
                    <span class="nav-unread"></span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                    <a href="#" class="dropdown-item d-flex">
                      <span class="avatar mr-3 align-self-center" style="background-image: url(demo/faces/male/41.jpg)"></span>
                      <div>
                        <strong>Nathan</strong> pushed new commit: Fix page load performance issue.
                        <div class="small text-muted">10 minutes ago</div>
                      </div>
                    </a>
                    <a href="#" class="dropdown-item d-flex">
                      <span class="avatar mr-3 align-self-center" style="background-image: url(demo/faces/female/1.jpg)"></span>
                      <div>
                        <strong>Alice</strong> started new task: Tabler UI design.
                        <div class="small text-muted">1 hour ago</div>
                      </div>
                    </a>
                    <a href="#" class="dropdown-item d-flex">
                      <span class="avatar mr-3 align-self-center" style="background-image: url(demo/faces/female/18.jpg)"></span>
                      <div>
                        <strong>Rose</strong> deployed new version of NodeJS REST Api V3
                        <div class="small text-muted">2 hours ago</div>
                      </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item text-center text-muted-dark">Mark all as read</a>
                  </div>
                </div>
                <div class="dropdown">
                  <a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
                    <span class="avatar" style="background-image: url(./demo/faces/female/25.jpg)"></span>
                    <span class="ml-2 d-none d-lg-block">
                      <span class="text-default">{{auth()->user()->name}}</span>
                      <small class="text-muted d-block mt-1">Administrator</small>
                    </span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                    <a class="dropdown-item" href="#">
                      <i class="dropdown-icon fe fe-user"></i> Profile
                    </a>
                    <a class="dropdown-item" href="#">
                      <i class="dropdown-icon fe fe-settings"></i> Settings
                    </a>
                    <a class="dropdown-item" href="#">
                      <span class="float-right"><span class="badge badge-primary">6</span></span>
                      <i class="dropdown-icon fe fe-mail"></i> Inbox
                    </a>
                    <a class="dropdown-item" href="#">
                      <i class="dropdown-icon fe fe-send"></i> Message
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">
                      <i class="dropdown-icon fe fe-help-circle"></i> Need help?
                    </a>
                    <a class="dropdown-item" href="#">
                      <i class="dropdown-icon fe fe-log-out"></i> Sign out
                    </a>
                  </div>
                </div>
              </div>
              <a href="#" class="header-toggler d-lg-none ml-3 ml-lg-0" data-toggle="collapse" data-target="#headerMenuCollapse">
                <span class="header-toggler-icon"></span>
              </a>
            </div>
          </div>
        </div>
        <div class="header collapse d-lg-flex p-0" id="headerMenuCollapse">
          <div class="container">
            <div class="row align-items-center">
              <div class="col-lg-3 ml-auto">
                <form class="input-icon my-3 my-lg-0">
                  <input type="search" class="form-control header-search" placeholder="Search&hellip;" tabindex="1">
                  <div class="input-icon-addon">
                    <i class="fe fe-search"></i>
                  </div>
                </form>
              </div>
              <div class="col-lg order-lg-first">
                <ul class="nav nav-tabs border-0 flex-column flex-lg-row">
                  <li class="nav-item">
                    <a href="{{URL::to('cmv')}}" class="{{ Request::path() == 'cmv' ? 'nav-link active' : 'nav-link' }}"><i class="fe fe-home"></i> Home</a>
                  </li>
                  <li class="nav-item">
                    <a href="{{URL::to('cmv/chart/brand')}}"  class="{{ Request::path() == 'cmv/chart/brand' ? 'nav-link active' : 'nav-link' }}"><i class="fe fe-pie-chart"></i> Brand</a>
                  </li>
                  <li class="nav-item">
                    <a href="{{URL::to('cmv/chart/competitive-map')}}"  class="{{ Request::path() == 'cmv/chart/competitive-map' ? 'nav-link active' : 'nav-link' }}"><i class="fa fa-newspaper-o"></i>  Competitive Map</a>
                  </li>
                  <li class="nav-item">
                    <a href="{{URL::to('cmv/chart/by-target-audience')}}"  class="{{ Request::path() == 'cmv/chart/by-target-audience' ? 'nav-link active' : 'nav-link' }}"><i class="fa fa-street-view"></i> Target Audience</a>
                  </li>
                  <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link" data-toggle="dropdown"><i class="fe fe-box"></i> Master Data</a>
                    <div class="dropdown-menu dropdown-menu-arrow">
                      <a href="{{URL::to('cmv/sector')}}" class="dropdown-item ">Sector</a>
                      <a href="{{URL::to('cmv/category')}}" class="dropdown-item ">Category</a>
                      <a href="{{URL::to('cmv/brand')}}" class="dropdown-item ">Brand</a>
                      <a href="{{URL::to('cmv/demography')}}" class="dropdown-item ">Demography</a>
                      <a href="{{URL::to('cmv/target-audience')}}" class="dropdown-item ">Target Audience</a>
                      <a href="{{URL::to('cmv/variabel')}}" class="dropdown-item ">Variabel</a>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="my-3 my-md-5">
          <div class="container">
            @yield('content')
          </div>
        </div>
      </div>
      <footer class="footer">
        <div class="container">
          <div class="row align-items-center flex-row-reverse">
            <div class="col-auto ml-lg-auto">
              <div class="row align-items-center">
                <div class="col-auto">
                  <ul class="list-inline list-inline-dots mb-0">
                    <li class="list-inline-item"><a href="./docs/index.html">Documentation</a></li>
                    <li class="list-inline-item"><a href="./faq.html">FAQ</a></li>
                  </ul>
                </div>
                <div class="col-auto">
                  <a href="https://github.com/tabler/tabler" class="btn btn-outline-primary btn-sm">Source code</a>
                </div>
              </div>
            </div>
            <div class="col-12 col-lg-auto mt-3 mt-lg-0 text-center">
              Copyright © 2018 <a href=".">Tabler</a>. Theme by <a href="https://codecalm.net" target="_blank">codecalm.net</a> All rights reserved.
            </div>
          </div>
        </div>
      </footer>
    </div>
    @yield('js')
  </body>
</html>