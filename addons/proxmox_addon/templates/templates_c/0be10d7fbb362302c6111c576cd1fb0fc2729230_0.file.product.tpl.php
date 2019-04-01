<?php
/* Smarty version 3.1.33-p1, created on 2019-04-01 14:04:42
  from 'C:\Users\Baptiste\Desktop\Inova\whmcs\modules\servers\proxmox_addon\templates\admin\product.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33-p1',
  'unifunc' => 'content_5ca1fe5ad8b8a6_34414082',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0be10d7fbb362302c6111c576cd1fb0fc2729230' => 
    array (
      0 => 'C:\\Users\\Baptiste\\Desktop\\Inova\\whmcs\\modules\\servers\\proxmox_addon\\templates\\admin\\product.tpl',
      1 => 1554120053,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5ca1fe5ad8b8a6_34414082 (Smarty_Internal_Template $_smarty_tpl) {
?><tr>
	<td class="fieldarea" colspan="4" style="padding: 10px;font-weight: bold;background: #2162A3; color: white">Configuration de base</td>
</tr>

<tr>
	<td class="fieldlabel"  width="20%">Type</td>
	<td class="fieldarea">
		<select name="packageconfigoption[1]" class="form-control input-400">
			<option value="1" selected="selected">LXC</option>
		</select>
	</td>
</tr>
<tr>
	<td class="fieldlabel">Cluster</td>
	<td class="fieldarea">
	   	<select name="packageconfigoption[2]" id="cluster" class="form-control input-400">
	   		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['clusters']->value, 'cluster');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['cluster']->value) {
?>
				<option value="<?php echo $_smarty_tpl->tpl_vars['cluster']->value->id;?>
" <?php if ($_smarty_tpl->tpl_vars['product']->value->configoption2 === $_smarty_tpl->tpl_vars['cluster']->value->id) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['cluster']->value->name;?>
</option>
			<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
	   	</select>
	</td>
</tr>

<tr>
	<td class="fieldlabel">Démarrage</td>
	<td class="fieldarea">
		<label class="checkbox-inline">
			<input type="hidden" name="packageconfigoption[3]">
			<input type="checkbox" name="packageconfigoption[3]" <?php if ($_smarty_tpl->tpl_vars['product']->value->configoption3) {?>active<?php }?>> Lancer au boot de la machine
		</label>
	</td>
</tr>
	<td class="fieldlabel">Notes</td>
    <td class="fieldarea">
    	<textarea class="form-control input-400" name="packageconfigoption[4]" cols="60" rows="5">
<?php if ($_smarty_tpl->tpl_vars['product']->value->configoption4) {
echo $_smarty_tpl->tpl_vars['product']->value->configoption4;?>

<?php } else { ?>
Client: <?php echo $_smarty_tpl->tpl_vars['client_name']->value;?>
  (ID: <?php echo $_smarty_tpl->tpl_vars['client_id']->value;?>
)
Email: <?php echo $_smarty_tpl->tpl_vars['client_email']->value;?>

Service ID: <?php echo $_smarty_tpl->tpl_vars['service_id']->value;?>

Product:  <?php echo $_smarty_tpl->tpl_vars['product_name']->value;?>
 (ID: <?php echo $_smarty_tpl->tpl_vars['product_id']->value;?>
)
<?php }?>
    	</textarea>
    </td>
</tr>

<tr>
	<td class="fieldarea" colspan="4" style="padding: 10px;font-weight: bold;background: #2162A3; color: white">Ressources</td>
</tr>

<tr>
	<td class="fieldlabel">Cœurs CPU</td>
	<td class="fieldarea">
		<input type="text" name="packageconfigoption[5]" class="form-control input-400" value="<?php if ($_smarty_tpl->tpl_vars['product']->value->configoption5) {?>$product->configoption5<?php } else { ?>0<?php }?>">
		<p class="text-muted" style="padding-top: 5px;margin-bottom: 5px;">Laisser 0 pour donner l'accès à tous les cœurs.</p>
	</td>
</tr>

<tr>
	<td class="fieldlabel">Espace disque</td>
	<td class="fieldarea">
		<div class="input-group input-400">
			<input type="text" name="packageconfigoption[6]" class="form-control" value="<?php if ($_smarty_tpl->tpl_vars['product']->value->configoption6) {?>$product->configoption6<?php } else { ?>10<?php }?>">
			<span class="input-group-addon">Go</span>
		</div>
	</td>
</tr>
<tr>
	<td class="fieldlabel">Emplacement du disque système</td>
	<td class="fieldarea">
		<input type="text" name="packageconfigoption[7]" class="form-control input-400" value="<?php if ($_smarty_tpl->tpl_vars['product']->value->configoption7) {?>$product->configoption7<?php } else { ?>local<?php }?>">
	</td>
</tr>
<tr>
	<td class="fieldlabel">Ram</td>
	<td class="fieldarea">
		<div class="input-group input-400">
			<input type="text" name="packageconfigoption[8]" class="form-control" value="<?php if ($_smarty_tpl->tpl_vars['product']->value->configoption8) {?>$product->configoption8<?php } else { ?>2048<?php }?>">
			<span class="input-group-addon">Mo</span>
		</div>
	</td>
</tr>
<tr>
	<td class="fieldlabel">Swap</td>
	<td class="fieldarea">
		<div class="input-group input-400">
			<input type="text" name="packageconfigoption[9]" class="form-control" value="<?php if ($_smarty_tpl->tpl_vars['product']->value->configoption9) {?>$product->configoption9<?php } else { ?>1024<?php }?>">
			<span class="input-group-addon">Mo</span>
		</div>
	</td>
</tr>
  
<tr>
	<td class="fieldarea" colspan="4" style="padding: 10px;font-weight: bold;background: #2162A3; color: white">Backups</td>
</tr>

<tr>
	<td class="fieldlabel">Nombre de backups</td>
	<td class="fieldarea">
		<input type="text" name="packageconfigoption[10]" class="form-control input-400" value="<?php if ($_smarty_tpl->tpl_vars['product']->value->configoption10) {?>$product->configoption10<?php } else { ?>-1<?php }?>">
		<p class="text-muted" style="padding-top: 5px;margin-bottom: 5px;">Laisser -1 pour n'appliquer aucune limite</p>
</td>
</tr>
<tr>
	<td class="fieldlabel">Emplacement du disque backup</td>
	<td class="fieldarea">
		<input type="text" name="packageconfigoption[11]" class="form-control input-400" value="<?php if ($_smarty_tpl->tpl_vars['product']->value->configoption11) {?>$product->configoption11<?php } else { ?>local<?php }?>">
	</td>
</tr>
<tr>
	<td class="fieldlabel">Nombre de jours de conservation des backups</td>
	<td class="fieldarea">
		<input type="text" name="packageconfigoption[12]" class="form-control input-400" value="<?php if ($_smarty_tpl->tpl_vars['product']->value->configoption12) {?>$product->configoption12<?php } else { ?>-1<?php }?>">
		<p class="text-muted" style="padding-top: 5px;margin-bottom: 5px;">Laisser -1 pour n'appliquer aucune limite</p>
	</td>
</tr>

<tr>
	<td class="fieldarea" colspan="4" style="padding: 10px;font-weight: bold;background: #2162A3; color: white">Réseau</td>
</tr>
<tr>
	<td class="fieldlabel">Eth0</td>
	<td class="fieldarea">
		<select name="packageconfigoption[13]" class="bridge form-control input-400">
			<option value="-1">Aucune interface</option>
	   		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['interfaces']->value, 'interface');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['interface']->value) {
?>
				<option value="<?php echo $_smarty_tpl->tpl_vars['interface']->value->id;?>
" <?php if ($_smarty_tpl->tpl_vars['product']->value->configoption13 == $_smarty_tpl->tpl_vars['interface']->value->id) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['interface']->value->name;?>
</option>
			<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
	   	</select>
		<p class="help-block hidden">Chargement des interfaces ...</p>
	</td>
</tr>

<tr>
	<td class="fieldlabel">Eth1</td>
	<td class="fieldarea">
		<select name="packageconfigoption[14]" class="bridge form-control input-400">
			<option value="-1">Aucune interface</option>
	   		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['interfaces']->value, 'interface');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['interface']->value) {
?>
				<option value="<?php echo $_smarty_tpl->tpl_vars['interface']->value->id;?>
" <?php if ($_smarty_tpl->tpl_vars['product']->value->configoption14 == $_smarty_tpl->tpl_vars['interface']->value->id) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['interface']->value->name;?>
</option>
			<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
	   	</select>
		<p class="help-block hidden">Chargement des interfaces ...</p>
	</td>
</tr>

<tr>
	<td class="fieldlabel">Eth2</td>
	<td class="fieldarea">
		<select name="packageconfigoption[15]" class="bridge form-control input-400">
			<option value="-1">Aucune interface</option>
	   		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['interfaces']->value, 'interface');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['interface']->value) {
?>
				<option value="<?php echo $_smarty_tpl->tpl_vars['interface']->value->id;?>
" <?php if ($_smarty_tpl->tpl_vars['product']->value->configoption15 == $_smarty_tpl->tpl_vars['interface']->value->id) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['interface']->value->name;?>
</option>
			<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
	   	</select>
		<p class="help-block hidden">Chargement des interfaces ...</p>
	</td>
</tr>

<tr>
	<td class="fieldlabel">Eth3</td>
	<td class="fieldarea">
		<select name="packageconfigoption[16]" class="bridge form-control input-400">
			<option value="-1">Aucune interface</option>
	   		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['interfaces']->value, 'interface');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['interface']->value) {
?>
				<option value="<?php echo $_smarty_tpl->tpl_vars['cluster']->value->id;?>
" <?php if ($_smarty_tpl->tpl_vars['product']->value->configoption16 == $_smarty_tpl->tpl_vars['interface']->value->id) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['interface']->value->name;?>
</option>
			<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
	   	</select>
		<p class="help-block hidden">Chargement des interfaces ...</p>
	</td>
</tr>



<?php echo '<script'; ?>
>
		
	let lock = 0;

	$('form').submit(function (e) {
		if (lock) e.preventDefault();
	})

	let select = function() {
		let id = $('#cluster option:selected').val();
		let route = 'addonmodules.php?module=proxmox_addon&action=api&method=interfaces';

		$('.help-block')
			.removeClass('hidden')
			.html('Chargement des interfaces ...');

		$('.bridge').prop('disabled', false);
		$('.btn-primary').prop('disabled', false);
		$('.bridge option').remove();

		$.get(`${route}&id=${id}`, function (data) {
			lock = 0;
			$('.help-block').addClass('hidden');

			if (!data.success) {
				$('.help-block')
					.removeClass('hidden')
					.html(data.message);
				$('.bridge').prop('disabled', true);
				$('.btn-primary').prop('disabled', true);
				lock = 1;
				return;
			}

			$('.bridge')
					.append($('<option></option>')
						.attr('value', '-1')
						.text('Aucune interface')
					);

			for (let interface of data.interfaces) {
				$('.bridge')
					.append($('<option></option>')
						.attr('value', interface.id)
						.text(interface.name)
					);
			}
		});
	}

	$('#cluster').change(select);
<?php echo '</script'; ?>
>
<?php }
}
