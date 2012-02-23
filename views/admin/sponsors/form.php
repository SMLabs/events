	<frameset class="inactive" id="sponsor_<?=$num?>">
		<input type="hidden" name="sponsors-delete[<?=$num?>]" value="false">
		<ul>
			<li>
				<label for="sponsor-name_<?=$num?>">Name <small>The name of your sponsor</small></label>
				<div class="input type-text"><input type="text" name="sponsors-name[<?=$num?>]" id="sponsor-name_<?=$num?>" value="<?=$name?>"/></div>
			</li>

			<li>
				<label for="sponsors-url_<?=$num?>">Link <small>The url for your sponsors website or page</small></label>
				<div class="input type-text"><input type="text" name="sponsors-url[<?=$num?>]" id="sponsors-url_<?=$num?>" value="$name" /></div>
			</li>

			<li>
				<label for="sponsors-logo_<?=$num?>">logo <small>The url to your sponsors logo</small></label>
				<div class="input type-text"><input type="text" name="sponsors-logo[<?=$num?>]" id="sponsors-logo_<?=$num?>" value="$name" /></div>
			</li>

			<li>
				<label for="sponsors-description_<?=$num?>">Description <small>A brief description of your sponsor.</small></label>
				<div class="input type-text"><textarea type="text" name="sponsors-description_<?=$num?>" id="sponsors-description_<?=$num?>"><?=$description?></textarea></div>
			</li>
		</ul>
		<div class="buttons padding-top align-right">
			<button type="submit" name="btnAction" value="save" class="btn blue"><span>Save</span></button>
			<button type="submit" name="btnAction" value="save" class="btn blue"><span>Delete</span></button>
		</div>
	</frameset>