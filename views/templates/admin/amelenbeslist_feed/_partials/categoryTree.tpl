<div class="category-tree">
	<div class="input-group flex-nowrap">
		<span class="input-group-text" id="addon-wrapping"><i class="material-icons">&#xe8b6;</i></span>
		<input
				data-id_category="{if $category.id_beslist_category == NULL}{else}{$category.id_beslist_category}{/if}"
				type="text"
				class="category-tree__search-input form-control"
				value="{if $category.beslist_name == NULL}{else}{$category.beslist_name}{/if}"
			    placeholder="{if $category.beslist_name == NULL}Export do kategorii{else}{$category.beslist_name}{/if}"
				aria-label="Username"
				aria-describedby="addon-wrapping">
	</div>
</div>