{{--<link href="{{ secure_url('css/bootstrap.min.css') }}" rel="stylesheet"/>--}}


@extends('appcheckout')
@section('content')

<div class="container" style="margin-top: 110px;">
	@foreach($viewpromotion as $index => $prow)
		<div style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 0px 0px 0 rgba(0, 0, 0, 0.19);padding-left: 0px;padding-right: 0px;margin-bottom: 20px">
			<img style='border-radius: 10px;' src="https://klikigrsim.mitraindogrosir.co.id/image/{{$prow['image']}}" class="img-responsive imgbox" height="100%">
		</div>

		<ul class="nav nav-tabs col-xs-12" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 0px 0px 0 rgba(0, 0, 0, 0.19);padding-left: 0px;padding-right: 0px;">
			<li class="col-xs-6 active" style="
				padding-left: 0px;
				padding-right: 0px;"><a href="#Home" data-toggle="tab" style="text-align: center"><span style="color:dodgerblue;font-size: large">Tentang Promo</span></a>
			</li>
			<li class="col-xs-6" style="
				padding-left: 0px;
				padding-right: 0px;"><a href="#Product" data-toggle="tab" style="text-align: center"><span style="color:dodgerblue; font-size: large">Syarat & Ketentuan</span></a>
			</li>
		</ul>

		<div class="tab-content">
			<div id="Product" class="tab-pane fade" style="padding-top: 80px;">
				{!! html_entity_decode(htmlspecialchars_decode($prow->terms)) !!}
			</div>
			<div id="Home" class="tab-pane fade in active" style="padding-top: 60px;">
				{!! html_entity_decode(htmlspecialchars_decode($prow->about)) !!}

				@if($tipe !== 5 && $tipe !== 4)
					<div class="col-md-12 col-sm-6" style='padding-right: 0px !important;padding-right: 0px;margin-top: 40px;'>
						@foreach($linkhdr as $index => $lrow)
							<div style="min-height: 50px;">
								@if($tipe == 1)
									<div class="col-sm-12" style="padding-top: 10px;padding-bottom: 10px;border-bottom-width: 2px;border-bottom-style: solid; border-color: gainsboro;font-weight: bold;font-size: large">
										<span style="text-align: left; color:black; font-size: large!important;font-weight: bold">{{$lrow['division']}}</span>
										<a class='btn btn-warning flat' style='float:right;' target="_blank" href={{ url('list/'.$lrow->link_id) }}><span>Lihat Selengkapnya &nbsp;</span></a>
									</div>
								@elseif($tipe == 2)

									<?php
									$div = \App\Models\Department::getDepPromotion($lrow['link_id']);
									?>

									<div class="col-sm-12" style="padding-top: 10px;padding-bottom: 10px;border-bottom-width: 2px;border-bottom-style: solid; border-color: gainsboro;font-weight: bold;font-size: large">
										<span style="text-align: left; color:black; font-size: large!important;font-weight: bold">{{$lrow['department']}}</span>
										<a class='btn btn-warning flat' style='float:right;' target="_blank" href={{ url('list/' .$div.'/'.$lrow->link_id) }}><span>Lihat Selengkapnya &nbsp;</span></a>
									</div>
								@else
									<?php
									$dep = \App\Models\Category::getKatPromotion($lrow['link_id']);

									$div = \App\Models\Department::getDepPromotion($dep);
									?>

									<div class="col-sm-12" style="padding-top: 10px;padding-bottom: 10px;border-bottom-width: 2px;border-bottom-style: solid; border-color: gainsboro;font-weight: bold;font-size: large">
										<span style="text-align: left; color:black; font-size: large!important;font-weight: bold">{{$lrow['category']}}</span>
										<a class='btn btn-warning flat' style='float:right;' target="_blank" href={{ url('list/' .$div.'/'.$dep.'/'.$lrow->link_id) }}><span>Lihat Selengkapnya &nbsp;</span></a>
									</div>
									{{--<p style="text-align: left; color:black; font-size: large!important;font-weight: bold">{{$lrow['category']}}</p><hr style='margin-top: 10px;margin-bottom: 10px;border-width: 3px;'/>--}}
								@endif

								<ul class="nav nav-tabs" style="border-bottom-width: 0px;margin-bottom: 30px">
									<?php
									$plupromo = \App\Models\Promotion::getProductPromo($lrow['link_id'], $lrow['link_type']);
									?>

									@foreach($plupromo as $index => $row)
										<div class="col-xs-6 col-md-3 col-md-15 col-sm-6" style="box-shadow : 0 1px 3px 0 rgba(0, 0, 0, 0.14);">
											<a href="{{ url('detail/'.$row->prdcd) }}" style="display:block">
												<div class="product-grid" style="margin-bottom: 0px;background-color: white;">
													@if($row['url_pic_prod'] != null)
														<div>
															<img style='padding:10%;' src="{{ $row['url_pic_prod'] }}" class="img-responsive imgbox" height="100%">
														</div>

													@elseif($row['kode_tag'] == 'N')
														<div>
															<img style='padding:10%;' src="{{ url('../resources/assets/img/nocart.png') }}" class="img-responsive imgbox" height="100%">
														</div>
													@else
														<div>
															<img style='padding:10%;' src="{{ url('../image/noimage.png') }}" class="img-responsive imgbox" height="100%">
														</div>

													@endif

													<div class="producttitle" style="font-size: small !important; color: black !important;min-height: 80px; text-align: center; padding-left: 10px; padding-right: 10px">{{ ucwords(strtolower($row['long_description'])) }}</div>

													<div class="productprice" style="min-height: 90px;">
														<div class="pricetext" style="font-size: 13px !important; text-align: center; color: rgb(247, 147, 30) ; font-weight: 600; padding-left: 10px; padding-right: 10px; padding-bottom: 10px;" >Rp. {{ number_format($row['hrg_jual'], 0, ',', '.') }}<span>/ {{ $row['unit'] }}</span><br/><span>(isi {{ $row['frac'] }}&nbsp;Pcs)</span></div>
													</div>
												</div>
											</a>
											<div data-id="{{$row['prdcd']}}" class="productdialog" style="text-align:center; margin-bottom: 10px;margin-top: 0px; border-width:0px; box-shadow : 0 1px 4px 0 rgba(0, 0, 0, 0.14);border-style:solid; border-color: #9e9e9e;border-left-width: 0px;border-top-width: 0px;border-bottom-width: 0px;text-align: center; background-color: white" >
												<a href="#" class="btn btn-default flat" data-target="#" data-href="#" style="display: block"><i class='fa fa-shopping-cart'></i>&nbsp; BELI</a>
											</div>
										</div>
									@endforeach
								</ul>
							</div>
						@endforeach
					</div>
				@elseif($tipe !== 4)
					<div class="col-md-12 col-sm-6" style='padding-right: 0px !important;padding-right: 0px;margin-top: 40px;'>
						@foreach($linkhdr as $index => $lrow)
							<div class="col-sm-12" style="padding-top: 10px;padding-bottom: 10px;border-bottom-width: 2px;border-bottom-style: solid; border-color: gainsboro;font-weight: bold;font-size: large">
								<span style="text-align: left; color:black; font-size: large!important;font-weight: bold">Brand Pilihan {{ ucwords(strtolower($lrow['link_id'])) }}</span>
								<a class='btn btn-warning flat' style='float:right;'  target="_blank" href={{ url('list?key='.$lrow->link_id) }}><span>Lihat Selengkapnya &nbsp;</span></a>
							</div>
							{{--<span style="text-align: left; color:black; font-size: large!important; font-weight: bold">Brand Pilihan {{ ucwords(strtolower($lrow['link_id'])) }}</span><hr style='margin-top: 10px;margin-bottom: 10px;border-width: 3px;'/>--}}

							<div style="min-height: 50px;padding-top: 20px;">
								<ul class="nav nav-tabs" style="border-bottom-width: 0px;margin-bottom: 30px">
									<?php
									$plupromo = \App\Models\Promotion::getProductPromo($lrow['link_id'], $lrow['link_type']);
									?>

									@foreach($plupromo as $index => $row)
										<div class="col-md-3" style="box-shadow : 0 1px 3px 0 rgba(0, 0, 0, 0.14);">
											<a href="{{ url('detail/'.$row->prdcd) }}" style="display:block">
												<div class="product-grid" style="margin-bottom: 0px;background-color: white;">
													@if($row['url_pic_prod'] != null)
														<div>
															<img style='padding:10%;' src="{{ $row['url_pic_prod'] }}" class="img-responsive imgbox" height="100%">
														</div>

													@elseif($row['kode_tag'] == 'N')
														<div>
															<img style='padding:10%;' src="{{ url('../resources/assets/img/nocart.png') }}" class="img-responsive imgbox" height="100%">
														</div>
													@else
														<div>
															<img style='padding:10%;' src="{{ url('../image/noimage.png') }}" class="img-responsive imgbox" height="100%">
														</div>

													@endif

													<div class="producttitle" style="font-size: small !important; color: black !important;min-height: 80px; text-align: center; padding-left: 10px; padding-right: 10px">{{ ucwords(strtolower($row['long_description'])) }}</div>

													<div class="productprice" style="min-height: 90px;">
														<div class="pricetext" style="font-size: 13px !important; text-align: center; color: rgb(247, 147, 30) ; font-weight: 600; padding-left: 10px; padding-right: 10px; padding-bottom: 10px;" >Rp. {{ number_format($row['hrg_jual'], 0, ',', '.') }}<span>/ {{ $row['unit'] }}</span><br/><span>(isi {{ $row['frac'] }}&nbsp;Pcs)</span></div>
													</div>
												</div>
											</a>
											<div data-id="{{$row['prdcd']}}" class="productdialog" style="text-align:center; margin-bottom: 10px;margin-top: 0px; border-width:0px; box-shadow : 0 1px 4px 0 rgba(0, 0, 0, 0.14);border-style:solid; border-color: #9e9e9e;border-left-width: 0px;border-top-width: 0px;border-bottom-width: 0px;text-align: center; background-color: white" >
												<a href="#" class="btn btn-default flat" data-target="#" data-href="#" style="display: block"><i class='fa fa-shopping-cart'></i>&nbsp; BELI</a>
											</div>
										</div>
									@endforeach
								</ul>
							</div>
						@endforeach
					</div>
				@else

					@foreach($linkhdr as $index => $lrow)
						<?php
						$plupromo = \App\Models\Promotion::getProductPromo($lrow['link_id'], $lrow['link_type']);
						?>

						<div class='col-xs-3' style="padding-right: 0px;padding-left: 0px;">
								@foreach ($plupromo as $index => $row)
									<div class="col-md-12" style="box-shadow : 0 1px 3px 0 rgba(0, 0, 0, 0.14);margin-top: 10px;">
										<a href="{{ url('detail/'.$row->prdcd) }}" style="display:block">
											<div class="product-grid" style="margin-bottom: 0px;background-color: white;">
												@if($row['url_pic_prod'] != null)
													<div>
														<img style='padding:10%;' src="{{ $row['url_pic_prod'] }}" class="img-responsive imgbox" height="100%">
													</div>

												@elseif($row['kode_tag'] == 'N')
													<div>
														<img style='padding:10%;' src="{{ url('../resources/assets/img/nocart.png') }}" class="img-responsive imgbox" height="100%">
													</div>
												@else
													<div>
														<img style='padding:10%;' src="{{ url('../image/noimage.png') }}" class="img-responsive imgbox" height="100%">
													</div>

												@endif

												<div class="producttitle" style="font-size: small !important; color: black !important;min-height: 80px; text-align: center; padding-left: 10px; padding-right: 10px">{{ ucwords(strtolower($row['long_description'])) }}</div>

												<div class="productprice" style="min-height: 90px;">
													<div class="pricetext" style="font-size: 13px !important; text-align: center; color: rgb(247, 147, 30) ; font-weight: 600; padding-left: 10px; padding-right: 10px; padding-bottom: 10px;" >Rp. {{ number_format($row['hrg_jual'], 0, ',', '.') }}<span>/ {{ $row['unit'] }}</span><br/><span>(isi {{ $row['frac'] }}&nbsp;Pcs)</span></div>
												</div>
											</div>
										</a>
										<div data-id="{{$row['prdcd']}}" class="productdialog" style="text-align:center; margin-bottom: 10px;margin-top: 0px; border-width:0px; box-shadow : 0 1px 4px 0 rgba(0, 0, 0, 0.14);border-style:solid; border-color: #9e9e9e;border-left-width: 0px;border-top-width: 0px;border-bottom-width: 0px;text-align: center; background-color: white" >
											<a href="#" class="btn btn-default flat" data-target="#" data-href="#" style="display: block"><i class='fa fa-shopping-cart'></i>&nbsp; BELI</a>
										</div>
									</div>
								@endforeach
						</div>
					@endforeach


				@endif
			</div>
		</div>
	@endforeach
</div>

@endsection
@section('scripts')

{{--<script src="{{ secure_url('js/jquery-2.1.4.js') }}"></script>--}}
{{--<script src="{{ secure_url('js/bootstrap.min.js') }}"></script>--}}