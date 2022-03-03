@extends('layouts.app')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12 mt-5">
            <h4 class="text-center">Shorten URLs</h4>
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">Hash Code</th>
                  <th scope="col">Main Url</th>
                  <th scope="col">Short Url</th>
                  <th scope="col">Expiry Time</th>
                  <th scope="col">Expiry Date</th>
                  <th scope="col">Qr Code</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                @forelse($shortLinks as $shortLink)
                    <tr>
                        <th>{{$shortLink->hash}}</th>
                        <td>{{$shortLink->main_url}}</td>
                        <td>{{url('/').'/'.$shortLink->hash}}</td>

                        <td>
                            @if($shortLink->expiry_time == 1)
                                <span class="badge bg-primary">Yes</span>
                            @else
                                 <span class="badge bg-danger">No</span>
                            @endif
                        </td>
                        <td>
                            @if($shortLink->expiry_date)
                                {{Carbon\Carbon::parse($shortLink->expiry_date)->format('Y-m-d');}}
                            @else
                                <span>N/A</span>
                            @endif
                        </td>

                        <td>
                            {{\QrCode::size(50)->generate(url('/').'/'.$shortLink->hash)}}
                        </td>

                        <td>
                           <a href="javascript:void(0)"  title="Copy Short Url" data-clipboard-text="{{url('/').'/'.$shortLink->hash}}" class="btn btn-primary btn-sm copy">Copy</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-muted text-center" colspan="100%">No Data Found</td>
                    </tr>
                @endforelse
              </tbody>
            </table>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $('.copy').on('click',function(){
            var clipboard = new ClipboardJS('.copy');
            notify('success','URL copied : '+$(this).data('clipboard-text'))
        });
    </script>
@endpush

