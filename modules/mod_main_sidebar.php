<?php
	$type = $this->getSecureParams("type");
	$action = $this->getSecureParams("action");
?>
<aside class="main-sidebar">
	<section class="sidebar">
		<div class="user-panel">
		</div>
		<ul class="sidebar-menu">
			<?php
			// $tabs = array(
			// 	'home'=>'fa-dashboard',
			// );
			//
			if($_SESSION[SESSIONNAME]->user_type == "employee"){
				$tabs["online_finance_managment"] = "fa-facebook";
				// $tabs["category"] = "fa-cog";
				// $tabs["shipment"] = "fa fa-cogs";
			}elseif($_SESSION[SESSIONNAME]->user_type == "client"){
				$tabs["account_statement"] = "fa-pie-chart";
				// $tabs["shipment"] = "fa fa-cogs";
			}elseif($_SESSION[SESSIONNAME]->user_type == "admin"){
				$tabs["home"] = "fa-dashboard";
				$tabs["contract_managment"] = "fa-archive";
				$tabs["online_finance_managment"] = "fa-facebook";
				$tabs["payment_managment"] = "fa-dollar";
				$tabs["account_statement"] = "fa-pie-chart";
				$tabs["account_statement_new"] = "fa-area-chart";
				$tabs["pending_online_finance_managment"] = "fa-spinner fa-spin";
				// $tabs["category"] = "fa-cog";
				// $tabs["shipment"] = "fa fa-cogs";
				// $tabs["contact_us"] = "fa-phone";
				// $tabs["about_us"] = "fa-list-alt";
				// $tabs["policy"] = "fa-cogs";
				// $tabs["faq"] = "fa-commenting";
				$tabs["users"] = "fa-users";
				$tabs["backup"] = "fa-database";
			}

			foreach ($tabs as $key => $value){
				if(is_array($value)){
					?>
					<li class="treeview">
	 			   <a href="javascript:void(0);">
						 <?php
						 if($key == "comunications"){
							 $icon = "fa-server";
							 $name = "Comunications";
						 }
						 ?>
	 			     <i class="fa <?php echo $icon; ?>"></i>
	 			     <span><?php echo $name; ?></span>
	 			     <span class="pull-right-container">
	 			       <i class="fa fa-angle-left pull-right"></i>
	 			     </span>
	 			   </a>
	 			   <ul class="treeview-menu">
						 <?php
						 foreach ($value as $k => $v) {
								$final_key = str_replace("_"," ",$k);
							 ?>
	 			     		<li><a href="index.php?type=comunication&action=<?php echo $k; ?>"><i class="fa <?php echo $v; ?>"></i> <?php echo $final_key; ?></a></li>
							 <?php
						 }
						 ?>
	 			   </ul>
	 			 </li>
					<?php
				}else {
					$view = "view";
					if($key == "home") $view = "dashboard";
					$url = $this->urlBuild($key,$view);
					if($_SESSION[SESSIONNAME]->user_type == "client"){
						if($key == "account_statement"){
							$url = "index.php?type=account_statement&action=specific&id=".$_SESSION[SESSIONNAME]->user_id;
						}
					}
					?>
					<li class="<?php if($type == $key) echo "active" ?> <?php if($key == "pending_online_finance_managment") echo 'pending_online_finance_managment'; ?>">
						<a href="<?php echo $url; ?>">
							<?php
								$final_key = str_replace("_"," ",$key);
								if($key == "home") $final_key = "الرئيسية";
								elseif($key == "backup") $final_key = "النسخ الإحتياطية";
								elseif($key == "users") $final_key = "إدارة الحسابات";
								elseif($key == "account_statement") $final_key = "كشف حساب للعميل";
								elseif($key == "contract_managment") $final_key = "إدارة العقود";
								elseif($key == "online_finance_managment") $final_key = "إدارة التمويل";
								elseif($key == "payment_managment") $final_key = "إدارة الدفعات";
								elseif($key == "pending_online_finance_managment") $final_key = "تمويلات معلقة";
								elseif($key == "account_statement_new") $final_key = "كشف الذمم";
							 ?>
							<i class="fa <?php echo $value; ?>"></i> <span style="text-transform: capitalize;"><?php echo $this->t($final_key); ?></span>
							<?php
								if($key == "pending_online_finance_managment" && $this->data->pending_online_finance_managment_num->pending_online_finance_managment_num){
									?>
										<span class="pull-right-container">
				              <small class="label pull-right bg-red"><?php echo $this->data->pending_online_finance_managment_num->pending_online_finance_managment_num; ?></small>
				            </span>
									<?php
								}
							?>
						</a>
					</li>
					<?php
				}
			}
			 ?>
		</ul>
	</section>
	</aside>
