@extends('layouts.app')
@section('title', '订单信息')

@section('content')

    <!-- Main Container  -->
    <div class="main-container container">
        <ul class="breadcrumb">
            <li><a href="#"><i class="fa fa-home"></i></a></li>
            <li><a href="#">订单信息</a></li>
        </ul>

        <div class="row">
            <!--Middle Part Start-->
            <div id="content" class="col-sm-9">
                <h2 class="title">订单信息</h2>

                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <td colspan="2" class="text-left">订单详细信息</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td style="width: 50%;" class="text-left"><b>订单编号:</b>{{$order->no}}
                            <br>
                            <br>
                            <b>添加日期:</b> {{ $order->created_at }}
                            <br>
                            <br>
                            <b>付款日期:</b> {{ $order->paid_at }}
                            <br>
                            <br>
                            <b>备注：</b>{{ $order->remark }}
                        </td>
                        <td style="width: 50%;" class="text-left"><b>付款方式:</b> {{ $order->payment_method }}

                        </td>
                    </tr>
                    </tbody>
                </table>
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <td style="width: 50%; vertical-align: top;" class="text-left">收件地址</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>

                        <td class="text-left">
                            {{ join(' ',$order->address) }}
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <td class="text-left">产品名称</td>
                            <td class="text-left">规格</td>
                            <td class="text-right">数量</td>
                            <td class="text-right">单价</td>
                            <td class="text-right">最终价</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($order->orderItems as $item)
                            <tr>
                                <td class="text-left">{{ $item->product->title }}</td>
                                <td class="text-left">{{ $item->productSku->title }}</td>
                                <td class="text-right">{{ $item->amount }}</td>
                                <td class="text-right">${{ $item->productSku->price }}</td>
                                <td style="white-space: nowrap;" class="text-right">
                                    @if(!$order->paid_at && !$order->closed)
                                        <a class="btn btn-primary" data-toggle="tooltip"
                                           href="{{ route('payment.alipay',['order'=>$order->id]) }}">继续支付</a>
                                    @elseif($order->closed)
                                        <a disabled class="btn btn-danger" data-toggle="tooltip" >订单已关闭</a>
                                    @else
                                        <a class="btn btn-danger" data-toggle="tooltip" href="return.html">申请退款</a>
                                    @endif
                                </td>

                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="3"></td>
                            <td class="text-right"><b>优惠卷</b>
                            </td>
                            <td class="text-right">$101.00</td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td class="text-right"><b>优惠额度</b>
                            </td>
                            <td class="text-right">$5.00</td>
                        </tr>

                        <tr>
                            <td colspan="3"></td>
                            <td class="text-right"><b>总价</b>
                            </td>
                            <td class="text-right">${{ $order->total_amount }}</td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                <h3>订单状态</h3>
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <td class="text-left">
                            时间
                        </td>
                        <td class="text-left">状态</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{ $order->updated_at }}</td>
                        @if($order->paid_at)
                            @if($order->refund_status === \App\Models\Order::REFUND_STATUS_PENDING)
                                <td class="text-left">已支付</td>
                            @else
                                <td class="text-left">{{ \App\Models\Order::$refundStatusMap[$order->refund_status] }}</td>
                                {{ \App\Models\Order::$refundStatusMap[$order->refund_status] }}
                            @endif

                        @elseif($order->closed)
                            <td class="text-left">已关闭</td>
                        @else
                            <td class="text-left">未支付</td>
                        @endif

                    </tr>

                    </tbody>
                </table>
                <div class="buttons clearfix">
                    <div class="pull-right"><a class="btn btn-primary" href="{{ route('orders.index') }}">返回</a>
                    </div>
                </div>


            </div>
            <!--Middle Part End-->

        </div>
    </div>
    <!-- //Main Container -->

@endsection