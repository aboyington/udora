<?php
/*
Widget-title: Body content
Widget-preview-image: /assets/img/widgets_preview/center_bodycontent.jpg
*/
?>

<div class="box-content">
    {page_body}
    {has_page_documents}
    <h4>{lang_Filerepository}</h4>
    <ul>
    {page_documents}
    <li>
        <a href="{url}">{filename}</a>
    </li>
    {/page_documents}
    </ul>
    {/has_page_documents}
</div>