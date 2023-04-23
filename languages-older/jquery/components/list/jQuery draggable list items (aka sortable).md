<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js">

You call .sortable() on the container of the list items you want to be draggable and sortable.

For it to work on mobile too, you add jQuery UI Touch Punch which is a small hack that enables the use of touch events on sites using the jQuery UI user interface library.
http://touchpunch.furf.com/


With handle/icon to drag:
$(function() {
	$("#cards").sortable({handle:".handle"}).disableSelection();
});

Without handle/icon to drag:
$(function() {
	$("#cards").sortable().disableSelection();
});


The element you call .sortable() on will be the containment where you can rearrange its direct children. In this example, the #cards is the containment and .card is the direct children that can be rearranged. It does NOT matter how many levels deep the handle is at, if applicable.
#cards > .card {
}

You can add lower opacity when an element is being dragged with opacity and a float value:
$("#cards").sortable({handle:".handle-habit", opacity: 0.5}).disableSelection();


Recommend that you can use a Font Awesome icon at the .handle element: 
fa fa-arrows-alt

Warning: contenteditable stops working when an element becomes sortable/draggable. Possible fix here if you require it:
https://stackoverflow.com/questions/6399131/html5-draggable-and-contenteditable-not-working-together