<?php
/* Smarty version 3.1.33-p1, created on 2019-04-01 12:50:56
  from 'C:\Users\Baptiste\Desktop\Inova\whmcs\modules\addons\proxmox_addon\templates\admin\template.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33-p1',
  'unifunc' => 'content_5ca1ed105caed7_85829871',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2bf72331393cbebf3c749311f1c3f695d06f11b1' => 
    array (
      0 => 'C:\\Users\\Baptiste\\Desktop\\Inova\\whmcs\\modules\\addons\\proxmox_addon\\templates\\admin\\template.tpl',
      1 => 1554113861,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5ca1ed105caed7_85829871 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
?>
<style>
	.table-product th{
		background: #1A4D80;
		color: #fff;
		padding: 5px;
	}

	.table-product th:not(:first-child){
		border-left: 2px solid;
	}

	table {
		width: 100%;
	}

	td {
		padding: 5px;
	}
</style>
<ul class="nav nav-tabs">
	<li <?php if (!$_smarty_tpl->tpl_vars['action']->value || $_smarty_tpl->tpl_vars['action']->value === 'index') {?>class="active"<?php }?>>
		<a href="<?php echo $_smarty_tpl->tpl_vars['route']->value->to('index');?>
"><?php echo $_smarty_tpl->tpl_vars['trans']->value['menu']['home'];?>
</a>
	</li>
	<li <?php if ($_smarty_tpl->tpl_vars['action']->value === 'cluster' || $_smarty_tpl->tpl_vars['action']->value === 'server') {?> class="active"<?php }?>>
		<a href="<?php echo $_smarty_tpl->tpl_vars['route']->value->to('cluster');?>
">Clusters</a>
	</li>
	<li <?php if ($_smarty_tpl->tpl_vars['action']->value === 'ip') {?>class="active"<?php }?>>
		<a href="<?php echo $_smarty_tpl->tpl_vars['route']->value->to('ip');?>
">Ips</a>
	</li>
	<li <?php if ($_smarty_tpl->tpl_vars['action']->value === 'interface') {?>class="active"<?php }?>>
		<a href="<?php echo $_smarty_tpl->tpl_vars['route']->value->to('interface');?>
">Interfaces</a>
	</li>
	<li <?php if ($_smarty_tpl->tpl_vars['action']->value === 'template') {?>class="active"<?php }?>>
		<a href="<?php echo $_smarty_tpl->tpl_vars['route']->value->to('template');?>
">Templates</a>
	</li>
</ul>
<br>

<?php if ($_smarty_tpl->tpl_vars['flash']->value->has('error')) {?>
    <div class="alert alert-danger">
        <strong><?php echo $_smarty_tpl->tpl_vars['trans']->value['error'];?>
 : </strong> <?php echo $_smarty_tpl->tpl_vars['flash']->value->get('error');?>

    </div>
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['flash']->value->has('success')) {?>
    <div class="alert alert-success">
        <strong><?php echo $_smarty_tpl->tpl_vars['trans']->value['success'];?>
 : </strong> <?php echo $_smarty_tpl->tpl_vars['flash']->value->get('success');?>

    </div>
<?php }?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_3648016825ca1ed105ca6d4_36340372', "content");
?>


<div class="text-center" style="margin-top: 50px;">
	<small>Promox Gateway by Uneo7 - Report issue to the project's <a target="_blank" href="https://github.com/Uneo7/WHMCS-Proxmox-Gateway">GitHub</a></small>
</div><?php }
/* {block "content"} */
class Block_3648016825ca1ed105ca6d4_36340372 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'content' => 
  array (
    0 => 'Block_3648016825ca1ed105ca6d4_36340372',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block "content"} */
}
