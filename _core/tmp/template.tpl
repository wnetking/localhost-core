<div class="project" style="background-image: url({preview});">
    <a href="{project_link}" class="project__link"></a>
    <div class="project_buttons">
        <a href="{admin}" class="project__admin" data-title="Admin Panel">{icon_admin_panel}</a>
        <a href="#" class="copy" onclick="copy_text(this)" data-title="Copy project link">{icon_copy} <span class="project_copy">{project_link}</span></a>
        <a href="{helper_link}" class="project__helper" data-title="Link to helper.php">{icon_helper}</a>
        <a href="#{theme_name}" class="project__create_base_pack" data-title="Create base pack for theme"
           onclick="createPack('{name_of_project}','{theme_name}')">{icon_pack}</a>
    </div>
    <span class="project__name">{name_of_project}</span>
</div>