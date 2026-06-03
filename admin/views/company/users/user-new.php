 <!-- start page title -->
                        <div class="page-title-box">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h6 class="page-title">Create  Users</h6>
                                    <?php include 'views'._.'includes/timer'.PL;?>
                                </div>
                                <div class="col-md-4">
                                    <div class="float-end d-none d-md-block">
                                        <div class="dropdown">
                                            <a class="btn btn-primary " aria-expanded="false" href="<?=DNADMIN?>/company/users/list">
                                                <i class="ti-menu-alt me-2"></i> All Users
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">New User</h4>
                                        <div class="card overflow-hidden">
                                            <div class="card-body " style="padding: unset !important;">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="p-3 form-card">
                                                           <form method="post" class="mt-2">

															<div class="mt-2 mb-0 row">
																<div class="col-12 mb-2">
																	<p class="mb-0" style="color: red;">* All fields are mandatory</p>
																</div>
															</div>

															<!-- First Name -->
															<div class="mb-4">
																<label class="form-label" for="user-firstname">First name</label>
																<span style="color: red; font-size: 12px; display: block">
																	<?php if($form->ERRORS){ echo @$form->ERRORS_SCRIPT['firstname'][0];}?>
																</span>
																<input type="text" class="form-control" 
																	id="user-firstname" 
																	name="user-firstname" 
																	placeholder="First name" required>
															</div>

															<!-- Last Name -->
															<div class="mb-4">
																<label class="form-label" for="user-lastname">Last name</label>
																<span style="color: red; font-size: 12px; display: block">
																	<?php if($form->ERRORS){ echo @$form->ERRORS_SCRIPT['lastname'][0];}?>
																</span>
																<input type="text" class="form-control" 
																	id="user-lastname" 
																	name="user-lastname" 
																	placeholder="Last name" required>
															</div>

															<!-- Email -->
															<div class="mb-4">
																<label class="form-label" for="user-email">Email</label>
																<span style="color: red; font-size: 12px; display: block">
																	<?php if($form->ERRORS){ echo @$form->ERRORS_SCRIPT['email'][0];}?>
																</span>
																<input type="email" class="form-control" 
																	id="user-email" 
																	name="user-email" 
																	placeholder="Email" required>
															</div>

															<!-- Telephone -->
															<div class="mb-4">
																<label class="form-label" for="user-telephone">Telephone</label>
																<span style="color: red; font-size: 12px; display: block">
																	<?php if($form->ERRORS){ echo @$form->ERRORS_SCRIPT['telephone'][0];}?>
																</span>
																<input type="text" class="form-control" 
																	id="user-telephone" 
																	name="user-telephone" 
																	placeholder="Telephone number" required>
															</div>

															<!-- Password -->
															<div class="mb-4">
																<label class="form-label" for="user-password">Password</label>
																<span style="color: red; font-size: 12px; display: block">
																	<?php if($form->ERRORS){ echo @$form->ERRORS_SCRIPT['password'][0];}?>
																</span>
																<input type="password" class="form-control" 
																	id="user-password" 
																	name="user-password" 
																	placeholder="Password" required>
															</div>

															<!-- Re-type Password -->
															<div class="mb-4">
																<label class="form-label" for="user-retype_password">Re-Type Password</label>
																<span style="color: red; font-size: 12px; display: block">
																	<?php if($form->ERRORS){ echo @$form->ERRORS_SCRIPT['retype_password'][0];}?>
																</span>
																<input type="password" class="form-control" 
																	id="user-retype_password" 
																	name="user-retype_password" 
																	placeholder="Re-Type Password" required>
															</div>

															<!-- Permission -->
															<div class="mb-4">
																<label class="form-label" for="user-groups">Permission</label>
																<span style="color: red; font-size: 12px; display: block">
																	<?php if($form->ERRORS){ echo @$form->ERRORS_SCRIPT['groups'][0];}?>
																</span>
																<select class="form-select" 
																		id="user-groups" 
																		name="user-groups" required>
																	<option value="">[ -- Select Permission -- ]</option>
																	<option value="Admin">Admin</option>
																	<option value="Sub-Admin">Sub-Admin</option>
																	<option value="Worker">Worker</option>
																</select>
															</div>

															<!-- Hidden Fields -->
															<input type="hidden" name="webToken" value="56">
															<input type="hidden" name="request" value="user-new">

															<!-- Submit -->
															<div class="mb-3 row">
																<div class="col-12 text-end">
																	<button class="btn btn-primary w-md waves-effect waves-light" 
																			type="submit">
																		Submit
																	</button>
																</div>
															</div>

														</form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                         
                        </div>
                        <!-- end row -->