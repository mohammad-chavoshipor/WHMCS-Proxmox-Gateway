<?php
/* Smarty version 3.1.33-p1, created on 2019-04-01 12:50:56
  from 'C:\Users\Baptiste\Desktop\Inova\whmcs\modules\addons\proxmox_addon\templates\admin\index.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33-p1',
  'unifunc' => 'content_5ca1ed1056dc70_20276071',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b6ebcd1f75c695e15b9d3817cca7dbec96599611' => 
    array (
      0 => 'C:\\Users\\Baptiste\\Desktop\\Inova\\whmcs\\modules\\addons\\proxmox_addon\\templates\\admin\\index.tpl',
      1 => 1554111592,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5ca1ed1056dc70_20276071 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_17504559225ca1ed10568e23_09835292', "content");
$_smarty_tpl->inheritance->endChild($_smarty_tpl, 'template.tpl');
}
/* {block "content"} */
class Block_17504559225ca1ed10568e23_09835292 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'content' => 
  array (
    0 => 'Block_17504559225ca1ed10568e23_09835292',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

	<div class="row">
		<div class="col-md-6">
			<h2><?php echo $_smarty_tpl->tpl_vars['trans']->value['home']['vm_list'];?>
</h2>
		</div>
	</div>
	<br>

	<pre>WIP</pre>
<?php
}
}
/* {/block "content"} */
}
