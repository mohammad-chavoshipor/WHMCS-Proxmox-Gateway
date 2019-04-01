<?php
/* Smarty version 3.1.33-p1, created on 2019-04-01 14:07:10
  from 'C:\Users\Baptiste\Desktop\Inova\whmcs\modules\addons\proxmox_addon\templates\admin\cluster\list.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33-p1',
  'unifunc' => 'content_5ca1feee257de7_86017665',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'fe683b7f9061bde8f5fc36f42ffd19706090d9ea' => 
    array (
      0 => 'C:\\Users\\Baptiste\\Desktop\\Inova\\whmcs\\modules\\addons\\proxmox_addon\\templates\\admin\\cluster\\list.tpl',
      1 => 1554112624,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5ca1feee257de7_86017665 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_7944758355ca1feee247e51_37117386', "content");
$_smarty_tpl->inheritance->endChild($_smarty_tpl, 'template.tpl');
}
/* {block "content"} */
class Block_7944758355ca1feee247e51_37117386 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'content' => 
  array (
    0 => 'Block_7944758355ca1feee247e51_37117386',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

	<div class=" text-right">
		<a href="<?php echo $_smarty_tpl->tpl_vars['route']->value->to('cluster',array('method'=>'add'));?>
" class="btn btn-sm btn-primary">
			<i class="fa fa-plus fa-fw"></i>
			<span class="hidden-md">Ajouter</span>
		</a>
	</div>
	<br>

	<table class="table-product">
		<thead>
			<tr>
				<th><?php echo $_smarty_tpl->tpl_vars['trans']->value['name'];?>
</th>
				<th>Serveurs</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['clusters']->value, 'cluster');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['cluster']->value) {
?>
			<tr>
				<td><?php echo $_smarty_tpl->tpl_vars['cluster']->value->name;?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['cluster']->value->nodes->count();?>
</td>
			
				<td>
					<div class="btn-group">
						<a onclick="return confirm('Voulez vous vraiment suppimer ce cluster ?');" href="<?php echo $_smarty_tpl->tpl_vars['route']->value->to('cluster',array('method'=>'delete','id'=>$_smarty_tpl->tpl_vars['cluster']->value->id));?>
" class="btn btn-sm btn-danger"><i class="fa fa-trash fa-fw"></i></a>
						<a href="<?php echo $_smarty_tpl->tpl_vars['route']->value->to('cluster',array('method'=>'edit','id'=>$_smarty_tpl->tpl_vars['cluster']->value->id));?>
" class="btn btn-sm btn-primary"><i class="fa fa-edit fa-fw"></i></a>
						<a href="<?php echo $_smarty_tpl->tpl_vars['route']->value->to('server',array('cluster'=>$_smarty_tpl->tpl_vars['cluster']->value->id));?>
" class="btn btn-sm btn-info"><i class="fa fa-server fa-fw"></i></a>
					</div>
				</td>
			</tr>
			 <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
		</tbody>
	</table>
<?php
}
}
/* {/block "content"} */
}
