<!-- BEGIN: MAIN -->

<div class="container container-fluid">
	<div class="page-header">
		
		<div class="row">
			<div class="col-md-10">
				<h1>{PAGEEDIT_PAGETITLE}: <small>{PHP.pag.page_title}</small></h1>	
			</div>
			<div class="col-md-2 text-right">
				<span class="label label-default">{PAGEEDIT_FORM_LOCALSTATUS}</span>
			</div>
		</div>
		
	</div>
	{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}

	<form action="{PAGEEDIT_FORM_SEND}" enctype="multipart/form-data" method="post" name="pageform">
		<div class="row">
			<div class="col-md-8">
				<div class="form-group">
					<label>{PHP.L.Title}</label>
					{PAGEEDIT_FORM_TITLE}
				</div>
				<div class="form-group">
					<label>{PHP.L.Description}</label>
					{PAGEEDIT_FORM_DESC}
				</div>
				<div class="form-group">
					<label>{PHP.L.Category}</label>
					{PAGEEDIT_FORM_CAT}
				</div>
				<!-- BEGIN: TAGS -->
				<div class="form-group">
					<label>{PAGEEDIT_TOP_TAGS} ({PAGEEDIT_TOP_TAGS_HINT})</label>
					{PAGEEDIT_FORM_TAGS|cot_rc_modify('$this', 'class="form-control"')}
				</div>
				<!-- END: TAGS -->
				{PAGEEDIT_FORM_TEXT}
				<!-- IF {PAGEEDIT_FORM_PFS} -->{PAGEEDIT_FORM_PFS}<!-- ENDIF -->
				<!-- IF {PAGEEDIT_FORM_SFS} --><span class="spaced">{PHP.cfg.separator}</span>{PAGEEDIT_FORM_SFS}<!-- ENDIF -->
				

			</div>
			<div class="col-md-4">
				<h4>{PHP.L.SEO}</h4>
				<div class="form-group">
					<label>{PHP.L.Alias}</label>
					{PAGEEDIT_FORM_ALIAS}
				</div>					
	
				<div class="form-group">
					<label>{PHP.L.page_metakeywords}</label>
					{PAGEEDIT_FORM_KEYWORDS}
				</div>	
				<div class="form-group">
					<label>{PHP.L.page_metatitle}</label>
					{PAGEEDIT_FORM_METATITLE}
				</div>	
				<div class="form-group">
					<label>{PHP.L.page_metadesc}</label>
					{PAGEEDIT_FORM_METADESC}
				</div>	
				<h4>{PHP.L.Other}</h4>
				<div class="form-group">
					<label>{PHP.L.Parser}</label>
					<div>{PAGEEDIT_FORM_PARSER}</div>
				</div>
				<!-- BEGIN: ADMIN -->
				<div class="form-group">
					<label>{PHP.L.Owner}: </label> {PAGEEDIT_FORM_OWNERID}
				</div>
				<div class="form-group">
					<label>{PHP.L.Hits}: </label> {PAGEEDIT_FORM_PAGECOUNT}
				</div>
				<!-- END: ADMIN -->
				<div class="form-group">
					<label>{PHP.L.Date}:</label>
					<div>{PAGEEDIT_FORM_DATE}</div>
					<small>{PAGEEDIT_FORM_DATENOW} {PHP.L.page_date_now}</small>
				</div>
				<div class="form-group">
					<label>{PHP.L.Begin}</label>
					<div>{PAGEEDIT_FORM_BEGIN}</div>
				</div>
				<div class="form-group">
					<label>{PHP.L.Expire}</label>
					<div>{PAGEEDIT_FORM_EXPIRE}</div>
				</div>			
			</div>
		</div>
		<div class="publish">
		<!-- IF {PHP.usr_can_publish} -->
			<button type="submit" name="rpagestate" value="0" class="btn btn-primary">{PHP.L.Publish}</button>
			<!-- ENDIF -->
			<button type="submit" name="rpagestate" value="2" class="submit btn btn-default">{PHP.L.Saveasdraft}</button>
			<button type="submit" name="rpagestate" value="1"  class="btn btn-default">{PHP.L.Submitforapproval}</button>
			<a href="{PAGEEDIT_FORM_ID|page_delete_url}" class="btn btn-danger confirmLink" >{PHP.L.Delete}</a>
		</div>
	</form>

	<div class="alert alert-info">{PHP.L.page_formhint}</div>			
</div>


<!-- END: MAIN -->
