<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

\Bitrix\Main\UI\Extension::load(['ui.design-tokens']);
?>
<script>
if (window.JCCalendarViewDay)
	jsBXAC.SetViewHandler(new JCCalendarViewDay());
else
	BX.loadScript(
        '/local/components/riat/service.calendar.view/templates/day/view.js',
		function() {jsBXAC.SetViewHandler(new JCCalendarViewDay())}
	);
</script>