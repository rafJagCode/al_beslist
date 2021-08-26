/**
 * 2007-2021 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 *  @author    PrestaShop SA <contact@prestashop.com>
 *  @copyright 2007-2021 PrestaShop SA
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 *
 * Don't forget to prefix your containers with your own identifier
 * to avoid any conflicts with others containers.
 */
$(document).ready(function () {

	function filterCategories(searchInput){
		const dropdown = searchInput.closest('.category-tree').children('.category-tree__dropdown');
		const categoriesList = dropdown.find('li');
		const input = searchInput.val().toLowerCase();

		$(categoriesList).hide().filter(function(){
			return $(this).text().toLowerCase().replace(/^\s+|\s+$|\t/g,'').includes(input);
		}).show();
	}

	$('.category-tree__search-input').on('focus', function () {
		if(!$(this).closest('.category-tree').children('.category-tree__dropdown').length){
			let controller_link = $('#amelenbeslistInputInfo').data('controller_link');
			$.ajax({
				url: controller_link,
				type: 'POST',
				cache: false,
				crossDomain: true,
				data: {
					ajax: 1,
					action: 'GET_BESLIST_CATEGORIES_DROPDOWN',
				},
				success: (res) => {
					$(this).closest('.category-tree').append(res);
				}
			});
		}

		filterCategories($(this));
		$(this).closest('.category-tree').children('.category-tree__dropdown').addClass('category-tree__dropdown--show');
	});

	$('.category-tree__search-input').on('blur', function () {
	$(this).closest('.category-tree').children('.category-tree__dropdown').removeClass('category-tree__dropdown--show');
	});

	$('.category-tree__search-input').on('input', function () {

	filterCategories($(this));

 });

 $('.category-tree').on('mousedown', '.category-tree__dropdown li', function(){
	 const chosenCategory = $(this).text().replace(/^\s+|\s+$|\t/g,'');
	 const id_category = $(this).data('category_id');
	 $(this).closest('.category-tree').find('.category-tree__search-input').val(chosenCategory);
	 $(this).closest('.category-tree').find('.category-tree__search-input').data('id_category', id_category);
 });

 $('.amelenbeslit__generate-feed-btn').on('click', function(){
	 $(this).find('.loading-content').show();
	 $(this).find('.loaded-content').hide();
	 let controller_link = $('#amelenbeslistInputInfo').data('controller_link');
	 let categoryMapping = {};
	 let lacozziCategories = [];
	 $('.category-checkbox').toArray().forEach((checkbox) =>{
	 	if(!checkbox.checked) return;
	 	lacozziCategories.push($(checkbox).val());
	 	categoryMapping[`${$(checkbox).val()}`] = $(checkbox).closest('.categories__row').find('.category-tree__search-input').data('id_category');
	 })
	 $.ajax({
		 url: controller_link,
		 type: 'POST',
		 cache: false,
		 crossDomain: true,
		 data: {
			 ajax: 1,
			 action: 'GENERATE_FEED',
			 categoryMapping: categoryMapping,
			 lacozziCategories: lacozziCategories
		 },
		 success: () => {
			 $(this).find('.loading-content').hide();
			 $(this).find('.loaded-content').show();
		 }
	 });
 });

	$('.amelenbeslit__save--feed-settings-btn').on('click', function(){
		$(this).find('.loading-content').show();
		$(this).find('.loaded-content').hide();

		let controller_link = $('#amelenbeslistInputInfo').data('controller_link');
		let settings = [];
		$('.categories__row').toArray().forEach((category) =>{
			let checkbox = $(category).find('.category-checkbox');
			let id_category = checkbox.val();
			let category_name = checkbox.data('category_name');
			let enabled = checkbox.is(':checked');
			let input = $(category).find('.category-tree__search-input');
			let id_beslist_category = input.data('id_category');
			let beslist_category_name = input.val();
			let categorySettings = {
				id_category: id_category,
				enabled: enabled,
				name: category_name,
				beslist_name: beslist_category_name,
				id_beslist_category: id_beslist_category
			}
			settings.push(categorySettings);
		});
		$.ajax({
			url: controller_link,
			type: 'POST',
			cache: false,
			crossDomain: true,
			data: {
				ajax: 1,
				action: 'SAVE_FEED_SETTINGS',
				settings: settings
			},
			success: () => {
				$(this).find('.loading-content').hide();
				$(this).find('.loaded-content').show();
			}
		});
	})


	//IMPORT FUNCTIONS

	// $('.amelenbeslist__order').on('click', function(){
	// 	let controller_link = $(this).data('controller_link');
	// 	let order = $(this).data('order');
	// 	console.log(controller_link, order);
	// })
});
