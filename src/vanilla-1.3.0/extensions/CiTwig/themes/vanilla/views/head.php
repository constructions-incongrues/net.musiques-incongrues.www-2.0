<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="{{ self.Context.GetDefinition('XMLLang') }}">
	<head>
		<title>{{ self.Context.Configuration['APPLICATION_TITLE'] }} - {{ self.Context.PageTitle }}</title>
		<link rel="shortcut icon" href="{{ self.Context.StyleUrl }}favicon.ico" />

{% for metaName, metaContent in self.Meta %}
		<meta name="{{ metaName }}" content="{{ metaContent }}" />
{% endfor %}

{% for stylesheet in self.StyleSheets %}
		<link rel="stylesheet" type="text/css" href="{{ stylesheet.Sheet }}" {% if stylesheet.Media %}media="{{ stylesheet.Media }}"{% endif %}/>
{% endfor %}

{% for script in self.Scripts %}
		<script type="text/javascript" src="{{ script }}"></script>
{% endfor %}

{% for string in self.Strings %}
		{{ string }}
{% endfor %}
	</head>

<body id="{{ self.BodyId ?: '' }}" {{ self.Context.BodyAttributes }}>
	<div id="SiteContainer">
