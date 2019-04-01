<?php
/* Smarty version 3.1.33-p1, created on 2019-04-01 14:07:11
  from 'C:\Users\Baptiste\Desktop\Inova\whmcs\modules\addons\proxmox_addon\templates\admin\ips\list.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33-p1',
  'unifunc' => 'content_5ca1feefabb4a4_68619613',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f75a71c64d6f73b0a16a8f2473d23ae8ae6ca424' => 
    array (
      0 => 'C:\\Users\\Baptiste\\Desktop\\Inova\\whmcs\\modules\\addons\\proxmox_addon\\templates\\admin\\ips\\list.tpl',
      1 => 1554113176,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5ca1feefabb4a4_68619613 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_19090596075ca1feefaa7eb9_73244079', "content");
$_smarty_tpl->inheritance->endChild($_smarty_tpl, 'template.tpl');
}
/* {block "content"} */
class Block_19090596075ca1feefaa7eb9_73244079 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'content' => 
  array (
    0 => 'Block_19090596075ca1feefaa7eb9_73244079',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>


	<div class="text-right">
		<a href="<?php echo $_smarty_tpl->tpl_vars['route']->value->to('ip',array('method'=>'add'));?>
" class="btn btn-sm btn-primary">
			<i class="fa fa-plus fa-fw"></i>
			<span class="hidden-md">Ajouter</span>
		</a>
	</div>
	<br>

	<table class="table-product">
		<thead>
			<tr>
				<th>IP</th>
				<th>Masque</th>
				<th>Passrelle</th>
				<th>Cluster</th>
				<th>Status</th>
				<th>Service</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['ips']->value, 'ip');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['ip']->value) {
?>
			<tr>
				<td><?php echo $_smarty_tpl->tpl_vars['ip']->value->ip;?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['ip']->value->netmask;?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['ip']->value->gateway;?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['ip']->value->cluster->name;?>
</td>
				<td><?php if ($_smarty_tpl->tpl_vars['ip']->value->active) {?> <span class="label label-success">Publique</span><?php } else { ?><span class="label label-danger">Privée</span><?php }?></td>
				<td><?php if (!$_smarty_tpl->tpl_vars['ip']->value->used) {?> '<span class="label label-success">Libre</span><?php } else { ?><a href="clientsservices.php?id='.$ip->service_id.'">Voir</a><?php }?></td>
				<td>
					<div class="btn-group">
						<a onclick="return confirm('Voulez vous vraiment supprimer cette ip ? ')" href="<?php echo $_smarty_tpl->tpl_vars['route']->value->to('ip',array('method'=>'delete','id'=>$_smarty_tpl->tpl_vars['ip']->value->id));?>
" class="btn btn-xs btn-danger"><i class="fa fa-trash fa-fw"></i></a>
						<a href="<?php echo $_smarty_tpl->tpl_vars['route']->value->to('ip',array('method'=>'edit','id'=>$_smarty_tpl->tpl_vars['ip']->value->id));?>
" class="btn btn-xs btn-primary"><i class="fa fa-edit fa-fw"></i></a>
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
