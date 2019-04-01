<?php
/* Smarty version 3.1.33-p1, created on 2019-04-01 12:54:38
  from 'C:\Users\Baptiste\Desktop\Inova\whmcs\modules\servers\proxmox_addon\templates\admin\avanced.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33-p1',
  'unifunc' => 'content_5ca1edee8667e2_72317521',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '742a93f22d264499b695e8a79c174e418e2c0a95' => 
    array (
      0 => 'C:\\Users\\Baptiste\\Desktop\\Inova\\whmcs\\modules\\servers\\proxmox_addon\\templates\\admin\\avanced.tpl',
      1 => 1554116076,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5ca1edee8667e2_72317521 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="modal fade" id="module_reinstall" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content panel panel-primary">
			<div class="modal-header panel-heading">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">×</span>
					<span class="sr-only">Close</span>
				</button>
				<h4 class="modal-title">Confirm reinstall</h4>
			</div>
			<div class="modal-body panel-body">
			<p><strong>Please select an os :</strong></p>
			<select id="os-list" class="form-control">
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['templates']->value, 'template');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['template']->value) {
?>
					<option value="<?php echo $_smarty_tpl->tpl_vars['template']->value->id;?>
"><?php echo $_smarty_tpl->tpl_vars['template']->value->name;?>
</option>;
				<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
			</select>
			</div>
			<div class="modal-footer panel-footer">
				<button type="button" class="btn btn-primary" onclick="runReinstall()">
					Reinstall
				</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">
					Cancel
				</button>
			</div>
		</div>
	</div>
</div>

<button type="button" class="btn btn-default" onclick="jQuery('#module_reinstall').modal('show');">Reinstall</button>
<button type="button" class="btn btn-default" onclick="openConsole()">Console</button>

<?php echo '<script'; ?>
>
	function openConsole() {
		window.open("<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
", "Console", "width=800,height=600");
		window.close();
	}
	function runReinstall() {
		$("#module_reinstall .btn-primary").attr("disabled", true);
		

		$.post("clientsservices.php", {
				modop: "custom",
				token: csrfToken,
				id: $("input[name=id]").val(),
				userid: $("input[name=userid]").val(),
				ajax: 1,
				ac: "reinstall",
				os: $("#os-list").val()
			})
			.done(function( data ) {
				location.reload();
			});
	}
<?php echo '</script'; ?>
><?php }
}
