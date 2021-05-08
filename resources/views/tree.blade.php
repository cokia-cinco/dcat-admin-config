<div class="card card-body">
    <div class="highlight bg-gray-light">
        @foreach($data as $k=>$v)
            <div class="p-1" data-toggle="collapse" href="#{{$k}}" aria-controls="{{$k}}">
                <span class="font-weight-bolder font-md-4">
                   {{ $k }}
                </span>
            </div>
            <div class="collapse show pl-0" id="{{$k}}">
                @foreach($v as $str )
                    <dl class="row">
                        <dt class="col-sm-4 text-right" style="color: #666">{{$str['name']}} :</dt>
                        <dd class="col-sm-5">
                            <span class="badge badge-secondary dd-toggle" data-title='{{$str['key']}}'>
                                {{\Illuminate\Support\Str::limit($str['key'],25)}}
                            </span>
                        </dd>
                        <dd class="col-sm-3">
                            <a class="text-right text-success copyableId" title="复制ID" data-content='{{$str['id']}}' href="#">
                                <i class="feather icon-copy"></i>
                            </a>
                            <a class="text-right text-success copyableKey" title="复制Key" data-content='{{$str['key']}}' href="#">
                                <i class="feather icon-copy"></i>
                            </a>
                            <a class="text-right text-warning edit-form" title="编辑" href="{{ admin_url('config/'.$str['key'].'/edit') }}">
                                <i class="feather icon-edit"></i>
                            </a>
                            <a class="text-right text-danger delete" title="删除" data-url="{{ admin_url('config/'.$str['key']) }}" href="#">
                                <i class="feather icon-trash-2"></i>
                            </a>
                        </dd>
                    </dl>
                @endforeach
            </div>
        @endforeach
    </div>
</div>
<script>
    Dcat.ready(function (){
        $('.copyableId').off('click').on('click', function (e) {
            let content = $(this).data('content');
            let $temp = $('<input>');
            $("body").append($temp);
            $temp.val(content).select();
            document.execCommand("copy");
            $temp.remove();
            $(this).tooltip('show');
        });

        $('.copyableKey').off('click').on('click', function (e) {
            let content = $(this).data('content');
            let $temp = $('<input>');
            $("body").append($temp);
            $temp.val(content).select();
            document.execCommand("copy");
            $temp.remove();
            $(this).tooltip('show');
        });

        $('.delete').off('click').on('click', function (e) {
            if (confirm("确认删除嘛") != true) {
                return ;
            }
            let url = $(this).data('url');
            $.ajax(
                {
                    url: url,
                    dataType: 'json',
                    type:"post",
                    delay: 250,
                    data: {_method:'delete'},
                    success: function (response) {
                        Dcat.handleJsonResponse(response);
                        return false;
                    },
                }
            );
        });
    });

</script>
