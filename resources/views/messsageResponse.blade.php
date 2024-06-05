
                            					<?php
                                use Illuminate\Support\Facades\Auth;

foreach ($message_id as $messages) {
                                    if (! empty($messages->getStudent)) {
                                        if ($messages->getStudent->role == 'student') {
                                            ?>
                            							<li class="mb-3">
														<div
															class="d-flex justify-content-start align-items-center userSection">
															<img src="{{$messages->getCreated->profile_photo_url}}"
																alt="Avatar" class="rounded-circle me-3" width="50">
															<div class="messageDetail">
																<p class="m-0 userName">
																	<span>{{$messages->getCreated->name}} <span
																		class="replyPill">Replied</span>
																	</span><span class="chatDate"><?=$messages->created_at ?></span>
																</p>

															</div>

														</div>
														<div class="messageOuter">
															<div class="left"></div>
															<div class="right">
														<?php

                                            if ($messages->type == 1) {
                                                echo $messages->message;
                                            } else {
                                                echo '<a href="' . $messages->getmessageDocument($messages->message_document) . '" target="_blank" >' . $messages->message_document . '</a>';
                                            }
                                            ?>
                                            </div>
														</div>
													</li>
                            							<?php
                                        }
                                    } else {
                                        ?>
                            							<li class="mb-3">
														<div class="d-flex align-items-center adminSection">
															<img src="{{$messages->getCreated->profile_photo_url}}"
																alt="Avatar" class="rounded-circle ms-3" width="50">
															<div>
																<p class="m-0 userName">
																	<span class="chatDate"><?=($messages->created_by != Auth::user()->id) ?   '' : $messages->created_at?></span><?php if($messages->created_by != Auth::user()->id){?> <span
																		class="replyPill">Reply</span> <?php }?><?= ($messages->created_by == Auth::user()->id) ? $messages->getCreated->name :''?> </p>



															</div>

														</div>
														<div class="adminMessageOuter">
															<div class="right">
																		<?php

                                        if ($messages->type == 1) {
                                            echo $messages->message;
                                        } else {
                                            echo '<a href="' . $messages->getmessageDocument($messages->message_document) . '" target="_blank">' . $messages->message_document . '</a>';
                                        }
                                        ?>
																	</div>
														</div>
													</li>
                            						<?php
                                    }
                                }
                                ?>
                                <li id="loader"><img
														src="{{asset('images/loading2.gif')}}"></li>