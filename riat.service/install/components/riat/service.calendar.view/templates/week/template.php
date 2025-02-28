<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

\Bitrix\Main\UI\Extension::load(['ui.design-tokens']);
?>
<script>
if (window.JCCalendarViewWeek)
	jsBXAC.SetViewHandler(new JCCalendarViewWeek());
else
	BX.loadScript(
        '/local/components/riat/service.calendar.view/templates/week/view.js',
		function() {jsBXAC.SetViewHandler(new JCCalendarViewWeek())}
	);
</script>