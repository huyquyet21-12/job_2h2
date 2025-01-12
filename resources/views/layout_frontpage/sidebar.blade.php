<div class="col-md-3">
	<div class="card card-refine card-plain">
							<div class="card-content">
								<form action="">
								<h4 class="card-title">
									Refine
									<button class="btn btn-default btn-fab btn-fab-mini btn-simple pull-right" rel="tooltip" title="" data-original-title="Reset Filter">
										<a class="btn btn-default btn-fab btn-fab-mini btn-simple pull-right" 
										rel="tooltip" data-original-title="Reset Filter"
										href="{{ route('applicant.index') }}">
									    </a>
										<i class="material-icons">cached</i>
									</button>
								</h4>
								<div class="panel panel-default panel-rose">
									<div class="panel-heading" role="tab" id="tabFilter">
										<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" 
										href="#collapseFilter" aria-expanded="false" aria-controls="collapseFilter">
											<h4 class="panel-title">Filter</h4>
											<i class="material-icons">keyboard_arrow_down</i>
										</a>
									</div>
									<div id="collapseFilter" class="panel-collapse collapse in" role="tabpanel" 
									    aria-labelledby="tabFilter">
										<div class="panel-body">
											<div class="checkbox">
												<label for="">Remotable</label>
												<select class="form-control" name="remotable" id="">
													@foreach($filterPostRemotable as $key => $val)
													   <option value="{{ $val }}"
													   @if($remotable == $val) selected @endif
													   >
														  {{ __('frontpage.' . $key) }}
													   </option>
													@endforeach
												</select>
											</div>
											<div class="checkbox">
												<label>
													<input type="checkbox" 
													value="1" 
													data-toggle="checkbox" 
													name="can_parttime"
													@if($searchCanPartTime))
													    checked
													@endif	
													>
													<span class="checkbox-material"><span class="check"></span></span>
													Can Part-time
												</label>
											</div>
										</div>
									</div>
								</div>
								<div class="panel panel-default panel-rose">
									<div class="panel-heading" role="tab" id="tabPrice">
										<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsePrice" aria-expanded="false" aria-controls="collapsePrice">
											<h4 class="panel-title">Price Range</h4>
											<i class="material-icons">keyboard_arrow_down</i>
										</a>
									</div>
									<div id="collapsePrice" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="tabPrice">
										<input type="hidden" name="min_salary" value="{{ $min_salary }}" id="input-min-salary">
										<input type="hidden" name="max_salary" value="{{ $max_salary }}" id="input-max-salary">
										<div class="panel-body panel-refine">
											<span class="pull-left">
												$<span id="span-min-salary">{{ $min_salary }}</span>
											</span>
											<span class="pull-right">
												$<span id="span-max-salary">{{ $max_salary }}</span>
											</span>
											<div class="clearfix"></div>
											<div id="sliderRefine" class="slider slider-rose noUi-target noUi-ltr noUi-horizontal"></div>
										</div>
									</div>
								</div>

								

								<div class="panel panel-default panel-rose">
									<div class="panel-heading" role="tab" id="tabLocation">
										<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseLocation" aria-expanded="false" aria-controls="collapseLocation">
											<h4 class="panel-title">{{ __('frontpage.location') }}</h4>
											<!-- Lay tu lang en hoac vi -> frontpage.php -->
											<i class="material-icons">keyboard_arrow_down</i>
										</a>
									</div>
									<div id="collapseLocation" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingThree">
										<div class="panel-body">
											@foreach($arrCity as $city)
											<div class="checkbox">
												<label>
													<input type="checkbox" 
													value="{{ $city }}" 
													data-toggle="checkbox" 
													name="cities[]"
													@if(in_array($city, $searchCities))
													    checked
													@endif	
													>
													<span class="checkbox-material"><span class="check"></span></span>
													{{ $city }}
												</label>
											</div>
											@endforeach
										</div>
								   </div>
							   </div>
							   
							   <button class="btn btn-rose btn-round align-items-center">
								  <i class="material-icons">search</i>
								  Search
							   </button>
							   </form>
							</div>
						</div><!-- end card -->
					</div>