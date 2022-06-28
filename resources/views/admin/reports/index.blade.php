@extends('layouts.admin.layout')

@section('content')


    <div class="content">

        <div class="card">
            <div class="card-body p-2 px-4">
                <h4 class="box-title border-bottom">Reports </h4>

            </div>
            <form method="GET">
                <div class="card_inner">
                    <div class="card-body pb-0 border-bottom">
                        <div class="row mb-3">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="Period">Period</label>
                                    <select name="period" id="period" class="form-control">
                                        <option disabled selected>Select</option>
                                        <option {{ $request['period'] == 'yesterday' ? 'selected' : '' }}
                                            value="yesterday">Yesterday</option>
                                        <option {{ $request['period'] == 'month' ? 'selected' : '' }} value="month">So
                                            far this month</option>
                                        <option {{ $request['period'] == 'seven_date' ? 'selected' : '' }}
                                            value="seven_days">last seven days</option>
                                        <option {{ $request['period'] == 'last_month' ? 'selected' : '' }}
                                            value="last_month">Last month</option>
                                        <option value="">Custom date</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">

                                    <label for="">Date Range</label>
                                    <input type="text" value="{{ $request['creation_date'] }}"
                                        placeholder="Creation Date" class='form-control demo sel_date daterange reset'
                                        name="creation_date" id="creation_date" autocomplete="off" readonly
                                        style="background:white" disabled>
                                    <input class="reset" type="hidden" name="startDate"
                                        value="{{ $request['startDate'] ?? '' }}">
                                    <input class="reset" type="hidden" name="endDate"
                                        value="{{ $request['endDate'] ?? '' }}">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Campaign</label>
                                    <select name="campaign" id="campaign" class="form-control">
                                        <option disabled selected>Select</option>
                                        @foreach ($data['campaign'] as $campaign)
                                            <option
                                                {{ trim($request['campaign']) == trim($campaign->campaign) ? 'selected' : '' }}
                                                value="{{ $campaign->campaign }}">{{ $campaign->campaign }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Format</label>
                                    <select name="format" id="format" class="form-control">
                                        <option disabled selected>Select</option>
                                        @foreach ($data['formats'] as $format)
                                            <option
                                                {{ trim($request['format']) == trim($format->format) ? 'selected' : '' }}
                                                value="{{ $format->format }}">{{ $format->format }}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Advertiser</label>
                                    <select name="advertiser" id="advertiser" class="form-control">
                                        <option disabled selected>Select</option>
                                        @foreach ($data['advertiser'] as $advertiser)
                                            <option
                                                {{ trim($request['advertiser']) == trim($advertiser->advertiser) ? 'selected' : '' }}
                                                value="{{ $advertiser->advertiser }}">{{ $advertiser->advertiser }}
                                            </option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                            {{-- <div class="col-md-1">
                                <div class="form-group">
                                    <label for="" class="" style="opacity: 0;">SEARCH</label>
                                    <button class="btn btn-primary cm-btn" id="export">Export</button>
                                </div>
                            </div> --}}
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="" class="" style="opacity: 0;">SEARCH</label>
                                    <button type="button" onclick="window.location='{{ route('reports') }}'"
                                        class="btn btn-danger cm-btn ">Reset</button>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 border-right">
                                        <div class="form-group">
                                            <h6 class="mb-3 h6_heading">Dimensions</h6>
                                            <select name="dimension" id="dimension" class="form-control">
                                                <option disabled selected>Select</option>
                                                <option
                                                    {{ trim($request['dimension']) == 'advertiser' ? 'selected' : '' }}
                                                    value="advertiser">Advertiser</option>
                                                <option {{ trim($request['dimension']) == 'campaign' ? 'selected' : '' }}
                                                    value="campaign">campaign</option>
                                                <option {{ trim($request['dimension']) == 'format' ? 'selected' : '' }}
                                                    value="format">Formats</option>
                                                <option {{ trim($request['dimension']) == 'date' ? 'selected' : '' }}
                                                    value="date">Date</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <h6 class="mb-3 h6_heading">Date</h6>
                                            <select name="filterDate" id="filterDate" class="form-control">
                                                <option disabled selected>Select</option>
                                                <option {{ trim($request['filterDate']) == 'byDay' ? 'selected' : '' }}
                                                    class="filterReset" value="byDay">By Day</option>
                                                <option {{ trim($request['filterDate']) == 'byMonth' ? 'selected' : '' }}
                                                    class="filterReset" value="byMonth">By Month</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div>
                                            <h6 class="mb-3 h6_heading text-center">Metrics </h6>
                                            <div class="Matrices">
                                                <ul class="p-0">
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" checked
                                                                id="inlineCheckbox1" name="impressions" value="impressions">
                                                            <label class="form-check-label"
                                                                for="inlineCheckbox1">Impressions</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox"
                                                                {{ $data['views'] ? 'checked' : '' }}
                                                                id="inlineCheckbox2" name="views" value="views">
                                                            <label class="form-check-label"
                                                                for="inlineCheckbox2">Views</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox"
                                                                {{ $data['clicks'] ? 'checked' : '' }}
                                                                id="inlineCheckbox3" name="clicks" value="clicks">
                                                            <label class="form-check-label"
                                                                for="inlineCheckbox3">Clicks</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox"
                                                                {{ $data['engagements'] ? 'checked' : '' }}
                                                                id="inlineCheckbox4" name="engagements"
                                                                value="engagements">
                                                            <label class="form-check-label"
                                                                for="inlineCheckbox4">Engagements</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox"
                                                                {{ $data['cpcvs'] ? 'checked' : '' }}
                                                                id="inlineCheckbox5" name="cpcv" value="cpcv">
                                                            <label class="form-check-label"
                                                                for="inlineCheckbox5">CPCV</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox"
                                                                {{ $data['ctrs'] ? 'checked' : '' }}
                                                                id="inlineCheckbox6" name="ctr" value="ctr">
                                                            <label class="form-check-label"
                                                                for="inlineCheckbox6">CTR</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox"
                                                                {{ $data['egRates'] ? 'checked' : '' }}
                                                                id="inlineCheckbox7" name="egRate" value="egRate">
                                                            <label class="form-check-label" for="inlineCheckbox7">Engage
                                                                rate
                                                            </label>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="generate_btn">
                        <button class="btn btn-success d-block w-75 m-auto">Generate</button>
                    </div>

                </div>
            </form>


        </div>
        <div class="card">
            <div class="no_report ">

                @if (!empty($data['views'] || $data['impressions'] || $data['clicks'] || $data['engagements'] || $data['cpcvs'] || $data['ctrs'] || $data['egRates']))
                    <div class="table_head text-right pr-2 mb-2 pt-2">
                        <button class="expo_button" id="export">Export</button>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                @if ($data['dimension'])
                                    <th scope="col">{{ ucFirst($data['dimension']) }}</th>
                                @endif
                                @if ($data['filterDate'])
                                    <th scope="col">Date</th>
                                @endif
                                @if ($data['impressions'])
                                    <th scope="col">Impressions</th>
                                @endif
                                @if ($data['views'])
                                    <th scope="col">Views</th>
                                @endif
                                @if ($data['clicks'])
                                    <th scope="col">Clicks</th>
                                @endif
                                @if ($data['engagements'])
                                    <th scope="col">Engagements</th>
                                @endif
                                @if ($data['cpcvs'])
                                    <th scope="col">CPCV</th>
                                @endif
                                @if ($data['ctrs'])
                                    <th scope="col">CTR</th>
                                @endif
                                @if ($data['egRates'])
                                    <th scope="col">Engage rate</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @if ($data['dimension'] || $data['filterDate'])
                                <?php $i = 0;
                                $val = $data['dimension']; ?>
                                @foreach ($data['overview'] as $value)
                                    <tr>
                                        @if ($data['dimension'])
                                            <td>{{ $value->$val }}</td>
                                        @endif
                                        @if ($data['filterDate'])
                                            <td>{{ $value->date }}</td>
                                        @endif
                                        @if ($data['impressions'])
                                            <td>{{ $value->impressions }}</td>
                                        @endif
                                        @if ($data['views'])
                                            <td>{{ $value->views }}</td>
                                        @endif
                                        @if ($data['clicks'])
                                            <td>{{ $value->clicks }}</td>
                                        @endif
                                        @if ($data['engagements'])
                                            <td>{{ $value->engagements }}</td>
                                        @endif
                                        @if ($data['cpcvs'])
                                            @if ($value->format == 'Branded Video (AA)' || $value->format == 'Bumper Ads / URL YouTube (KSV)' || $value->format == 'Pre Roll - In stream / URL YouTube (KSV)' || $value->format == 'Pre Roll 30¨ (AA / Programatic)')
                                                <td>{{ ($value->impressions ?? 0) == 0 ? 0 : round(($value->views / $value->impressions) * 100, 2) }}%
                                                </td>
                                            @else
                                                <td>N/A</td>
                                            @endif
                                        @endif

                                        @if ($data['ctrs'])
                                            @if ($value->format != 'Virtual OOH - Estático' && $value->format != 'Virtual OOH - GIF')
                                                <td>{{ ($value->impressions ?? 0) == 0 ? 0 : round(($value->clicks / $value->impressions) * 100, 2) }}%
                                                </td>
                                            @else
                                                <td>N/A</td>
                                            @endif
                                        @endif
                                        @if ($data['egRates'])
                                            @if ($value->format == 'Interstitial Tradicional (AA)' || $value->format == 'Interstitial / Carousel (AA)' || $value->format == 'Interstitial / Filmstrip (AA)' || $value->format == 'Interstitial / Minigame (AA)')
                                                <td>{{ ($value->impressions ?? 0) == 0 ? 0 : round(($value->engagements / $value->impressions) * 100, 2) }}%
                                                </td>
                                            @else
                                                <td>N/A</td>
                                            @endif
                                        @endif
                                    </tr>
                                    <?php $i++; ?>
                                @endforeach
                            @else
                                <tr>
                                    @if ($data['impressions'])
                                        <td>{{ $data['overview']->sum('impressions') }}</td>
                                    @endif
                                    @if ($data['views'])
                                        <td>{{ $data['overview']->sum('views') }}</td>
                                    @endif
                                    @if ($data['clicks'])
                                        <td>{{ $data['overview']->sum('clicks') }}</td>
                                    @endif
                                    @if ($data['engagements'])
                                        <td>{{ $data['overview']->sum('engagements') }}</td>
                                    @endif
                                    @if ($data['cpcvs'])
                                        <td>{{ $data['cpcv']->sum('impressions') == 0 ? 0 : round(($data['cpcv']->sum('views') / $data['cpcv']->sum('impressions')) * 100, 2) }}%
                                        </td>
                                    @endif
                                    @if ($data['ctrs'])
                                        <td>{{ $data['ctr']->sum('impressions') == 0 ? 0 : round(($data['ctr']->sum('clicks') / $data['ctr']->sum('impressions')) * 100, 2) }}%
                                        </td>
                                    @endif
                                    @if ($data['egRates'])
                                        <td>{{ $data['egRate']->sum('impressions') == 0 ? 0 : round(($data['egRate']->sum('engagements') / $data['egRate']->sum('impressions')) * 100, 2) }}%
                                        </td>
                                    @endif
                                </tr>
                            @endif


                        </tbody>
                    </table>
                @endif

            </div>
        </div>
    </div>


@endsection
@section('footer-script')
    <script>
        $(document).ready(function() {
            $("#period").change(function() {
                if ($(this).find(":selected").text() == 'Custom date') {
                    $('#creation_date').removeAttr("disabled");
                } else {
                    $('#creation_date').attr("disabled", "disabled");
                    $('.reset').val("");
                }
            });

            $("#dimension").change(function() {
                if ($(this).find(":selected").text() == 'Date') {
                    $('#filterDate').attr("disabled", "disabled");
                } else {
                    $('#filterDate').removeAttr("disabled");
                }
            });
            let selecteddimension = $('#dimension').val();
            if (selecteddimension == 'date') {
                $('#filterDate').attr("disabled", "disabled");
            }

            function download_csv(csv, filename) {
                var csvFile;
                var downloadLink;
                csvFile = new Blob([csv], {
                    type: "text/csv"
                });
                downloadLink = document.createElement("a");
                downloadLink.download = filename;
                downloadLink.href = window.URL.createObjectURL(csvFile);
                downloadLink.style.display = "none";
                document.body.appendChild(downloadLink);
                downloadLink.click();
            }

            function export_table_to_csv(html, filename) {
                var csv = [];
                var rows = document.querySelectorAll("table tr");
                for (var i = 0; i < rows.length; i++) {
                    var row = [],
                        cols = rows[i].querySelectorAll("td, th");
                    for (var j = 0; j < cols.length; j++)
                        row.push(cols[j].innerText);
                    csv.push(row.join(","));
                }
                download_csv(csv.join("\n"), filename);
            }

            document.querySelector("#export").addEventListener("click", function() {
                let date = new Date();
                var html = document.querySelector("table").outerHTML;
                export_table_to_csv(html, "report-" + date.getDate() + "." + (date.getMonth() + 1) + "." +
                    date
                    .getFullYear() + ".csv");
            });
        })
    </script>
@endsection
