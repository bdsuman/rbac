<div class="container-fluid">
    <div class="row">
    <div class="col-md-12 col-sm-12 col-lg-12">
        <div class="card px-5 py-5">
            <form action="{{ url('/reportPage') }}" >
                <div class="row">
                    <div class="col-4 p-1">
                        <label class="form-label">From Date</label>
                        <input type="date" class="form-control" id="fromDate" name="fromDate">
                    </div>
                    <div class="col-4 p-1">
                        <label class="form-label">To Date</label>
                        <input type="date" class="form-control" id="toDate" name="toDate">
                    </div>
                    <div class="col-4 p-1">
                        <label class="form-label">Event </label>
                        <select name="event_id" id="id" class="form-control">
                            <option value="">--select--</option>
                            @forelse ($events as $item)
                                <option value="{{ $item->id }}">{{ $item->title }}</option>
                            @empty
                                <option value="Income">No Event Found!</option>
                            @endforelse
                            
                        </select>
                    </div>
                    
                    <div class="col-12 p-1 mt-2">
                        <div class="align-items-center col float-center" align="center">
                            <button type="submit" class="btn m-0 btn-sm bg-gradient-primary">Search</button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="row justify-content-between ">
                <div class="align-items-center col">
                    <h6>Event Registration List</h6>
                </div>
                <div class="align-items-center col">
                    <button onclick="printPage('print');" class="float-end btn m-0 btn-sm bg-gradient-success">Print</button>
                </div>
            </div>
           
            <hr class="bg-secondary"/>
            <div id="print" class="table-responsive" width="100%">
                @if($status)
                <div class="align-items-center col">
                    <h6>{{ $status }}</h6>
                </div>
                @endif
                <table class="table  table-flush">
                    <thead>
                    <tr class="bg-light">
                        <th>Sl</th>
                        <th>Date</th>
                        <th>Event</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Email</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse ($registrations as $key=>$data )
                            <tr>
                                <td>{{ ++$key; }}</td>
                                <td>{{ App\Helper\Helper::dateCheck($data->date) }}</td>
                                <td>{{ $data->event->title }}</td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->mobile }}</td>
                                <td>{{ $data->email }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <h2 style="color:red;">No Record Found!</h2>
                                </td>
                            </tr>
                        @endforelse
                        
                    </tbody>
                 
                    <tfoot>
                        {{-- <tr class="bg-dark"  style="font-weight: bold; color:white;">
                            <td align="right">
                                Total
                            </td>
                            <td>
                               
                            </td>
                        </tr> --}}
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
</div>

<script>
	function printPage(id)
	{
		
	   var html="<html>";
		   html+= document.getElementById(id).innerHTML;
		   html+="</html>";

	   var printWin = window.open();
	   printWin.document.write(html);
	   printWin.document.close();
	   printWin.focus();
	   printWin.print();
	   printWin.close();
	}
</script>
