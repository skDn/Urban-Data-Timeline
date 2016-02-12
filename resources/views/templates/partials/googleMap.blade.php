@section('styles')
    @parent
    {!! Html::style('css/googleMaps.css') !!}
@stop

<input id="pac-input" class="controls" type="text" placeholder="Input a location"
       data-toggle="tooltip" data-placement="bottom" title="This will move the main maker to the specified location.">
<div id="googleMap" class="col-md-12 center-block"
     data-toggle="popover" data-placement="bottom"
     title="Hints"
     data-html="true"
     data-content="1. You can drag the main marker <br/>
                   2. The main marker show current location. <br/>
                   3. The other markers indicate venues nearby. <br/>
                   4. By clicking on a venue, you can get its timeseries."
        ></div>

<!-- START OF MODAL -->
<div id="venueSearchModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Do you want to get this venue's timeline?</h4>
            </div>
            <div class="modal-body">
                <p>If you want to get this venue's timeline, you will be redirected
                    to a page, containing the timeline series of the selected venue for the
                    specified date.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="submitVenueSearch()">Submit</button>
            </div>
        </div>
    </div>
</div> <!-- END OF MODAL -->


@section('scripts')
    @parent
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=true&libraries=places"></script>
    {!! Html::script('js/googleMaps.js') !!}
@stop