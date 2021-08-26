<div class="category-tree__dropdown category-tree__dropdown--show">
	<ul class="list-group">

		{$level1 = null}
		{$level2 = null}

	{foreach $beslistCategories as $category}

		{if $category|@array_slice:0:1|@key != $level1}

			{$level1 = $category|@array_slice:0:1|@key}
			<li class="list-group-item" data-category_id="{$category[$level1]}">
				{foreach $category|@array_slice:0:1 as $partCategory}
					{$partCategory@key}{if !$partCategory@last} / {/if}
				{/foreach}
			</li>
		{/if}

		{if $category|@count > 1 && $category|@array_slice:1:2|@key != $level2}
			{$level2 = $category|@array_slice:1:2|@key}
			<li class="list-group-item" data-category_id="{$category[$level2]}">
				{foreach $category|@array_slice:0:2 as $partCategory}
					{$partCategory@key}{if !$partCategory@last} / {/if}
				{/foreach}
			</li>
		{/if}

		{if $category|@count > 2}
			<li class="list-group-item" data-category_id="{$category|@end}">
				{foreach $category as $partCategory}
					{$partCategory@key}{if !$partCategory@last} / {/if}
				{/foreach}
			</li>
		{/if}

	{/foreach}
	</ul>
</div>