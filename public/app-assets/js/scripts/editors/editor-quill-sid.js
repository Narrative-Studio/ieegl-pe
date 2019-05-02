/*=========================================================================================
	File Name: editor-quill.js
	Description: Quill is a modern rich text editor built for compatibility and extensibility.
	----------------------------------------------------------------------------------------
	Item Name: Robust - Responsive Admin Template
	Version: 2.1
	Author: GeeksLabs
	Author URL: http://www.themeforest.net/user/geekslabs
==========================================================================================*/
(function(window, document, $) {
	'use strict';

	var EditorDescripcionCorta = new Quill('#snow-descripcion_corta .editor', {
		bounds: '#snow-descripcion_corta .editor',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline', 'strike'],
                ['link', 'blockquote'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' },{ 'align': [] }],
            ]
        },
		theme: 'snow'
	});

    var EditorDescripcion= new Quill('#snow-descripcion .editor', {
        bounds: '#snow-descripcion .editor',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline', 'strike'],
                ['link', 'blockquote'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' },{ 'align': [] }],
            ]
        },
        theme: 'snow'
    });

    var EditorComentarios= new Quill('#snow-comentarios .editor', {
        bounds: '#snow-comentarios .editor',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline', 'strike'],
                ['link', 'blockquote'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' },{ 'align': [] }],
            ]
        },
        theme: 'snow'
    });

    var form = document.getElementById('formConvocatoria');

    form.onsubmit = function() {
        var descripcion_corta = document.querySelector('input[name=descripcion_corta]');
        descripcion_corta.value = $('#snow-descripcion_corta .editor .ql-editor').html();

        var descripcion= document.querySelector('input[name=descripcion]');
        descripcion.value = $('#snow-descripcion .editor .ql-editor').html();

        var comentarios= document.querySelector('input[name=comentarios]');
        comentarios.value = $('#snow-comentarios .editor .ql-editor').html();

        return true;
    };

})(window, document, jQuery);