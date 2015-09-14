/**
 * Created by kovko on 23.7.2015.
 */
tinymce.init({
    selector: "textarea[name=article_content]",
    plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
    entities: "160,nbsp",
    entity_encoding: "named",
    entity_encoding: "raw"
});