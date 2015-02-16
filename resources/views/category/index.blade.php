@extends('app')

@section('breadcrumbs.items')
	<li class="active">Categories</li>
@endsection

@section('breadcrumbs.actions')
	<a href="#addCategoryModal" data-toggle="modal" class="btn btn-success btn-xs"><i class="fa fa-plus"></i> Add Category</a>
@endsection

@section('content')
	<div class="row">
		<div class="col-sm-12">
			<div class="list-group">
				@foreach ($categories as $category)
					<a href="/categories/{{ $category->id }}" class="list-group-item">
						<h4 class="list-group-item-heading">{{ $category->label }}</h4>
						<div class="list-group-item-text">
							<div class="progress">
								<div class="progress-bar
								@if ($category->balance < $category->budgeted)
									progress-bar-success
								@elseif ($category->balance == $category->budgeted)
									progress-bar-warning
								@else
									progress-bar-danger
								@endif
								progress-bar-striped" role="progressbar" aria-valuenow="{{ $category->progress }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $category->progress }}%; min-width: 1%;">
									{{ $category->progress }}%
									<span class="sr-only">{{ $category->progress }}% Complete</span>
								</div>
							</div>
						</div>
						<p class="list-group-item-text pull-right">$ {{ number_format($category->budgeted, 2) }}</p>
						<p class="list-group-item-text">$ {{ number_format($category->balance, 2) }} spent</p>
					</a>
				@endforeach
			</div>
		</div>
	</div>

	<div id="addCategoryModal" class="modal fade">
		<div class="modal-dialog">
			<form class="modal-content form-horizontal" method="POST" action="/categories">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Add a Category</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label class="col-sm-3 control-label">Label</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="label" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Budget Amount</label>
						<div class="col-sm-8">
							<div class="input-group">
								<span class="input-group-addon">$</span>
								<input type="text" class="form-control" name="amount" required>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Interest Rate</label>
						<div class="col-sm-8">
							<div class="input-group">
								<input type="text" class="form-control" name="interest">
								<span class="input-group-addon">%</span>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save</button>
				</div>
			</form>
		</div>
	</div>
@endsection