<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
<input type="hidden" data-controller_link="{$controller_link}" id="amelenbeslistInputInfo"/>
<div class="categories">
{foreach $psCategories as $category}
	<div class="row flex-row categories__row align-items-stretch">
		<div class="col-md-2" style="display: flex;">
			<div class="input-group">
				<div class="input-group-text">
					<input
							class="category-checkbox form-check-input mt-0"
							type="checkbox" value="{$category.id_category}"
							data-category_name="{$category.name}"
							aria-label="Checkbox for {$category.name} input"
							{if $category.enabled}checked{/if}
					>
				</div>
				<input placeholder="{$category.name}" type="text" class="form-control" aria-label="Category field with checkbox" readonly>
				</div>
			</div>
			<div class="col-md-6">
				{include file="./_partials/categoryTree.tpl"}
			</div>
	</div>
	{/foreach}
</div>


<div class="control-buttons__container">
	<button class="amelenbeslit__generate-feed-btn btn btn-success">
		<div class="loading-content" style="display: none">
			<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
			<span class="sr-only">Generowanie...</span>
		</div>
		<div class="loaded-content">
			Wygeneruj FEED
		</div>
	</button>

	<button class="amelenbeslit__save--feed-settings-btn btn btn-success">
		<div class="loading-content" style="display: none">
			<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
			<span class="sr-only">Zapisywanie...</span>
		</div>
		<div class="loaded-content">
			Zapisz Ustawienia
		</div>
	</button>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>