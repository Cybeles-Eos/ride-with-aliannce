<?php

return '
        $this->call(CouponCodesTableSeeder::class);
        $this->call(CartsTableSeeder::class);
        $this->call(OrderAddressDetailsTableSeeder::class);
        $this->call(OrderCouponDetailsTableSeeder::class);
        $this->call(OrderItemDetailsTableSeeder::class);
        $this->call(OrderLogsTableSeeder::class);
        $this->call(OrderPaymentDetailsTableSeeder::class);
        $this->call(OrderShippingDetailsTableSeeder::class);
        $this->call(OrderStatusTableSeeder::class);
        $this->call(OrderTaxDetailsTableSeeder::class);
        $this->call(OrdersTableSeeder::class);';