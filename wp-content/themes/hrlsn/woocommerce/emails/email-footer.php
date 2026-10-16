<?php
/**
 * Email Footer
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 7.4.0
 */

defined( 'ABSPATH' ) || exit;

$instagramLink = HRLSN_OPTIONS['hrlsn_social_instagram'];
$youtubeLink = HRLSN_OPTIONS['hrlsn_social_youtube'];
?>
																		</div>
																	</td>
																</tr>
																<tr>
																	<td class="bottom_cell" align="center" valign="top">
																		<!-- Footer -->
																		<table border="0" cellpadding="0" cellspacing="0" width="100%" id="template_footer">
																			<tr>
																				<td valign="top">
																					<table border="0" cellpadding="0" cellspacing="0" width="100%">
																						<tr>
																							<td colspan="2" valign="middle" id="credit">
																								<table border="0" cellpadding="0" cellspacing="0" width="100%">
																									<tr>
																										<td valign="middle" align="left" id="credit">
																											<br><br><span class="cross_1"></span>
																										</td>
																										<td valign="middle" align="right" id="credit">
																											<br><br><span class="cross_2"></span>
																										</td>
																									</tr>
																								</table>
																								<p class="social">
																									<a href="<?php echo $instagramLink; ?>" class="instagram" target="_blank"></a>
																									<a href="<?php echo $youtubeLink; ?>" class="youtube" target="_blank"></a>
																								</p>
																								<p class="upper">
																									<?php esc_html_e( 'For any questions related to orders, delivery and payment, please write to', 'hrlsn' ); ?> <?php echo getEmailLink(); ?>
																								</p>

																								<?php
																								/*
																								echo wp_kses_post(
																									wpautop(
																										wptexturize(
																											apply_filters( 'woocommerce_email_footer_text', get_option( 'woocommerce_email_footer_text' ) )
																										)
																									)
																								);*/
																								?>
																							</td>
																						</tr>
																					</table>
																				</td>
																			</tr>
																		</table>
																		<!-- End Footer -->
																	</td>
																</tr>
															</table>
															<!-- End Content -->
														</td>
													</tr>
												</table>
												<!-- End Body -->
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</div>
				</td>
				<td><!-- Deliberately empty to support consistent sizing and layout across multiple email clients. --></td>
			</tr>
		</table>
	</body>
</html>
