/**
 * Created by Aaron Allen on 8/8/2016.
 */

define([
    'jquery'
], function ($) {
    'use strict';

    return function (config, element) {
        var amountElement = $(config.amount),
            constantElement = $(config.isConstant),
            progressElement = $(config.progressBar),
            numPages = config.numPages,
            pageSize = config.batchSize,
            curPage = 1;

        // on submit
        $(element).click(function () {
            //TODO validate input

            progressElement.text('0% Complete');
            sendRequest(curPage);

            //TODO disable inputs
        });

        function sendRequest(pageNumber) {
            $.post(
                '/admin/priceupdate/ajax/updatebatch',
                {
                    is_constant: constantElement.val(),
                    amount: amountElement.val(),
                    current_page: pageNumber,
                    page_size: pageSize
                }, function (response) {
                    if (response === 'Done') {
                        // update progress
                        progressElement.text((curPage / numPages * 100).toFixed(1) + '% Complete');
                        // request next batch
                        if (curPage < numPages) {
                            curPage++;
                            sendRequest(curPage);
                        }
                    }else{
                        progressElement.text('An error occurred.');
                    }
                }
            );
        }
    }
});