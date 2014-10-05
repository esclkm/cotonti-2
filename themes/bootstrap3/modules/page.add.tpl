<!-- BEGIN: MAIN -->

<div class="container container-fluid">
	<div class="page-header">
		<h1>{PAGEADD_PAGETITLE}</h1>
	</div>
	{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}

	<form action="{PAGEADD_FORM_SEND}" enctype="multipart/form-data" method="post" name="pageform">
		<div class="row">
			<div class="col-md-8">
				<div class="form-group">
					<label>{PHP.L.Title}</label>
					{PAGEADD_FORM_TITLE}
				</div>
				<div class="form-group">
					<label>{PHP.L.Description}</label>
					{PAGEADD_FORM_DESC}
				</div>
				<div class="form-group">
					<label>{PHP.L.Category}</label>
					{PAGEADD_FORM_CAT}
				</div>
				<!-- BEGIN: TAGS -->
				<div class="form-group">
					<label>{PAGEADD_TOP_TAGS} ({PAGEADD_TOP_TAGS_HINT})</label>
					{PAGEADD_FORM_TAGS|cot_rc_modify('$this', 'class="form-control"')}
				</div>
				<!-- END: TAGS -->				
				{PAGEADD_FORM_TEXT}
				<!-- IF {PAGEADD_FORM_PFS} -->{PAGEADD_FORM_PFS}<!-- ENDIF -->
				<!-- IF {PAGEADD_FORM_SFS} --><span class="spaced">{PHP.cfg.separator}</span>{PAGEADD_FORM_SFS}<!-- ENDIF -->
				

			</div>
			<div class="col-md-4">
				<h4>{PHP.L.SEO}</h4>
				<div class="form-group">
					<label>{PHP.L.Alias}</label>
					{PAGEADD_FORM_ALIAS}
				</div>						
				<div class="form-group">
					<label>{PHP.L.page_metakeywords}</label>
					{PAGEADD_FORM_KEYWORDS}
				</div>	
				<div class="form-group">
					<label>{PHP.L.page_metatitle}</label>
					{PAGEADD_FORM_METATITLE}
				</div>	
				<div class="form-group">
					<label>{PHP.L.page_metadesc}</label>
					{PAGEADD_FORM_METADESC}
				</div>	
				<h4>{PHP.L.Other}</h4>
				<div class="form-group">
					<label>{PHP.L.Parser}</label>
					<div>{PAGEADD_FORM_PARSER}</div>
				</div>
				<div class="form-group">
					<label>{PHP.L.Owner}: </label> {PAGEADD_FORM_OWNER}
				</div>	
				<div class="form-group">
					<label>{PHP.L.Begin}</label>
					<div>{PAGEADD_FORM_BEGIN}</div>
				</div>
				<div class="form-group">
					<label>{PHP.L.Expire}</label>
					<div>{PAGEADD_FORM_EXPIRE}</div>
				</div>			
			</div>
		</div>
		<div class="publish">
		<!-- IF {PHP.usr_can_publish} -->
			<button type="submit" name="rpagestate" value="0" class="btn btn-primary">{PHP.L.Publish}</button>
			<!-- ENDIF -->
			<button type="submit" name="rpagestate" value="2" class="submit btn btn-default">{PHP.L.Saveasdraft}</button>
			<button type="submit" name="rpagestate" value="1"  class="btn btn-default">{PHP.L.Submitforapproval}</button>
		</div>
	</form>

	<div class="alert alert-info">{PHP.L.page_formhint}</div>			
</div>


<!-- END: MAIN -->