<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: "Times New Roman", Times, serif;
            font-size: 11pt;
            color: #333;
        }

        .page {
            width: 794px;
            min-height: 1123px;
            margin: 40px auto;
            background: #fff;
            position: relative;
            box-shadow: 0 10px 40px rgba(0, 0, 0, .15);
            overflow: hidden;
        }


        /* FOOTER */
        .footer {
            position: absolute;
            bottom: 40px;
            left: 0;
            width: 100%;
            text-align: center;
            font-size: 9pt;
            color: #777;
        }


        /* CONTENT BLOCK */
        .content {
            position: relative;
            padding: 40px 60px 60px 60px;
        }


        /* HEADINGS */
        .h1 {
            font-size: 22pt;
            font-weight: bold;
            margin-bottom: 8pt;
        }

        .h2 {
            font-size: 15pt;
            font-weight: bold;
            margin-bottom: 14pt;
        }

        p {
            font-size: 10pt;
            line-height: 1.4;
        }

        h4 {
            font-size: 11pt;
            margin-top: 14px;
        }


        .page-bg img {
            width: 100%;
            display: block;
        }


        /* TABLE */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 14pt;
        }

        .table th,
        .table td {
            border: 1px solid #888;
            padding: 6pt;
            font-size: 10pt;
        }

        .table th {
            background: #eee;
        }

        .page::before {
            content: "Preview Page";
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 10px;
            color: #aaa;
        }
    </style>
</head>

<body>

    <!-- ================= PAGE 1 (COVER) ================= -->
    <div class="page">

        <!-- FULL COVER ART -->
        <div class="page-bg">
            <img src="{{ asset('img/survey-proposal/page1_img1.png') }}">
        </div>

        <div style="position: absolute; top: 850px; left: 420px;">
            <div style="color: #58595b; font-size: 22px; margin-top: 6px;">Prepared Exclusively For</div>
            <div style="color: #58595b; font-size: 22px; margin-left: 20px;">{{ $survey->company->name }}</div>
        </div>

        <div class="footer">
            © {{ now()->year }} GermBlast. All Rights Reserved.
        </div>
    </div>

    <!-- ================= PAGE 2 ================= -->
    <div class="page">

        <!-- HEADER STRIP -->
        <div class="page-bg">
            <img src="{{ asset('img/survey-proposal/page2_img1.png') }}">
        </div>

        <div class="content">
            <p>
                THANK YOU for considering GermBlast® as part of your Illness and Infection Prevention Program. We are
                pleased to
                provide you with this information about our company and services. Please review the following site
                survey report and
                consider the quote that is included. We appreciate the opportunity to present this report and look
                forward to creating a
                mutually beneficial relationship with your facility by “keeping the fight outside the body.”
            </p>

            <h4>The GOAL of GermBlast®</h4>
            <p>
                To provide the optimal illness/infection management solution for your organization’s needs. To that end,
                we have
                assembled a team of the leading experts in the medical and scientific fields. Our team will provide you
                with the
                knowledge and support necessary to effectively combat infectious agents including bacteria, virus, fungi
                and mold. “A
                healthier environment begins here.”®
            </p>

            <h4>The PURPOSE of GermBlast®</h4>
            <p>
                Controlling illness and infection is a critical component of stakeholder performance and attendance.
                Surface-mediated
                infectious disease transmission is a major concern in various settings including; homes, schools, gyms,
                hospitals, food
                processing facilities, daycares, and more. Chemical disinfectants are frequently used to reduce
                contamination, but many
                pose significant risks to humans, surfaces, and the environment. In addition, the processes used for so
                many years are
                proving ineffective at reducing illness. Lastly, there is growing concern over antibiotic resistance and
                the constant
                mutation of these microorganisms to adapt. That is why we created the GermBlast Program, a new and
                innovative germ
                killing and prevention technology. Our four pillar approach is proven to reduce illness and infection
                through high-level
                disinfection, data, education, and stakeholder awareness
            </p>

            <h4>The GermBlast® Difference</h4>
            <p>
                As Infection Prevention Professionals, we understand that the challenges associated with preventing the
                transmission of
                infection are not strictly limited to the tools we use but the knowledge we possess. That is why we have
                assembled a
                team of experts in epidemiology, microbiology, biochemistry, and statistics. GermBlast is more than
                cutting edge
                technology in Infection Prevention. We collect quantitative data which is used by the client and our
                professional staff to
                make evidence-based decisions. We combine advanced technology with innovation and process improvement.
                This
                unique combination was designed specifically to “Keep the Fight Outside of the Body.”®
            </p>

            <h4>GermBlast Bioburden Maintenance Plan</h4>
            <p>
                The GermBlast Program is an ideal way to enhance your organization’s infection prevention procedures.
                Routine
                practices can help mitigate the transmission of pathogens such as influenza, norovirus, enterovirus,
                staph, strep, and
                rotavirus (Carling, et. al. Journal Hospital Infection 2008; 68: 39-44)
            </p>
        </div>

        <div class="footer">
            © {{ now()->year }} GermBlast. All Rights Reserved.
        </div>
    </div>

    <!-- ================= PAGE 3 ================= -->
    <div class="page">

        <div class="page-bg">
            <img src="{{ asset('img/survey-proposal/page3_img1.png') }}">
        </div>

        <div class="content">
            <h4>The GermBlast Pillars</h4>

            <div style="text-align: center; margin:0px auto;">
                <img src="{{ asset('img/survey-proposal/page3_img2.png') }}"
                    style="display:block; width:306pt; margin:18pt auto 20pt auto;">
            </div>

            <h4>GermBlast Service</h4>
            <p>
                GermBlast offers the most complete and detailed service on the market to combat the spread of illness
                and infection. The
                subsequent paragraphs outline GermBlast’s high-level disinfection process in detail, but the GermBlast
                System goes
                above and beyond offering service alone. GermBlast Service is only one of four pillars working
                symbiotically to
                enhance prevention
            </p>

            <h4>GermStats</h4>
            <p>GermStats is an infection prevention software developed by GermBlast and made accessible to our clients
                through the
                web portal GermStats.com. With GermStats, you are able to track data gathered from your environment as
                well as
                receive information that is valuable to your organization, such as upcoming service details and emerging
                trends in
                disease and infection prevention.</p>

            <h4>Education</h4>
            <p>Comprehensive education is crucial to any organization’s success in infection prevention. GermBlast
                recognizes the
                value of education and provides customized, in-depth training for the members of your staff responsible
                for cleaning,
                disinfection, and infection control monitoring. Through this pillar, your staff will gain tools to make
                their efforts more
                focused, efficient, and effective.</p>

            <h4>Awareness</h4>
            <p>
                A partnership with GermBlast is an assurance to your stakeholders that you are going the extra mile to
                help keep them
                healthy by actively working towards infection prevention in your environment. As part of your GermBlast
                contract,
                an
                illness prevention campaign in the forms of print ads, handouts, table tents, and more are created by
                our marketing team
                and made available to GermBlast clients to convey your commitment to “keeping the fight outside the
                body.”
            </p>

        </div>

        <div class="footer">
            © {{ now()->year }} GermBlast. All Rights Reserved.
        </div>
    </div>

    <!-- ================= PAGE 4 ================= -->
    <div class="page">

        <div class="page-bg">
            <img src="{{ asset('img/survey-proposal/page4_img1.png') }}">
        </div>

        <div class="content">

            <h4>GermBlast Service - Available Applications</h4>

            <h4>GermBlast Service - Description</h4>

            <h4>GermBlast Pretreatment</h4>
            <p>
                Before a surface can be disinfected, it must first be cleaned. GermBlast staff utilize disposable,
                antimicrobial microfiber
                cloths in conjunction with a pretreatment chemical, Oxivir Five 16 or Opti-cide 3. GermBlast
                Pretreatment
                breaks
                through biofilm allowing for a more efficient sanitizing and disinfecting step.
            </p>

            <h4>GermBlast Spray</h4>
            <p>
                GermBlast Spray utilizes a rapid kill surface disinfectant. This powerful, hospital-grade disinfectant
                kills 99.999% of
                detectable pathogens. State of the art spraying systems help technicians achieve an efficient coverage.
                This GermBlast
                Spray modality is non-corrosive, non-toxic, and non-staining.
            </p>

            <h4>GermBlast Steam</h4>
            <p>
                GermBlast Steam offers a unique solution that allows an extremely high level of cleanliness while
                disinfecting the
                establishment, the dual purpose cleaning makes the process much more effective. A diverse assortment of
                pathogenic
                microorganisms can be rapidly killed by GermBlast Steam within 5 seconds. Risks of infection from
                contaminated
                surfaces will decrease further with more frequent treatments.
            </p>

            <h4>GermBlast PCO (Photocatalytic Oxidation)</h4>
            <p>
                GermBlast UV-PCO is one of the most effective air purification devices. It is capable of disinfecting
                over
                60 harmful
                airborne pathogens including norovirus, tuberculosis, pneumonia, and influenza virus. UV-PCO creates a
                reaction
                between ultraviolet light and a titanium dioxide based catalyst in the presence of water that oxidizes
                and eliminates
                microorganisms circulating in the air.
            </p>

            <h4>GermBlast H2O2</h4>
            <p>
                GermBlast Dry Mist H2O2 utilizes a hydrogen peroxide and silver based disinfectant to eliminate the most
                robust
                microorganisms in an environment. This modality utilizes dry mist technology to atomize the disinfectant
                and distribute
                it throughout the environment ensuring complete coverage of an area from ceiling to floor. GermBlast
                H2O2 will not
                damage electronics or surfaces and breaks down into oxygen and water without leaving a residue.
            </p>

            <h4>GermBlast Shield</h4>
            <p>
                GermBlast Shield employs an innovative polymer that adheres to surfaces and inhibits odor-causing
                microorganism
                colonization, yet is safe to touch. The polymer is applied using electrostatic spraying technology that
                ensure 100%
                coverage by negatively charging chemicals, causing them to completely and efficiently cover every
                surface.
                Surface
                protection lasts for up to 90 days.
            </p>

        </div>

        <div class="footer">
            © {{ now()->year }} GermBlast. All Rights Reserved.
        </div>

    </div>


    <!-- ================= PAGE 5 ================= -->
    {{-- <div class="page">

        <div class="page-bg">
            <img src="{{ asset('img/survey-proposal/page5_img1.png') }}">
        </div>

        <div class="content">

            <h4>GermBlast Proposal - Borger ISD - Entire District - 3 Service Program</h4>

            <!-- COMPANY DETAILS -->
            <table style="width:100%; font-size:10pt; margin-bottom:12pt;">
                <tr>
                    <td style="width:50%; vertical-align:top;">
                        <strong>Infection Controls, Inc.</strong><br>
                        1414 Avenue J<br>
                        Lubbock, TX 79401<br>
                        877.771.3558<br>
                        Fax: 806.771.3559
                    </td>
                    <!-- Company Address  -->
                    <td style="width:50%; vertical-align:top;">
                        <strong>Borger ISD</strong><br>
                        200 East Ninth St<br>
                        Borger, TX 79007<br>
                        806.273.1000
                    </td>
                </tr>
            </table>

            <!-- PROPOSAL META -->
            <table class="table" style="margin-bottom:14pt;">
                <tr>
                    <th>Proposal ID</th>
                    <th>Services Per Year</th>
                    <th>Contract Term</th>
                    <th>Payment Terms</th>
                </tr>
                <tr>
                    <td>107655</td>
                    <td>3</td>
                    <td>1 year(s)</td>
                    <td>Due on Receipt</td>
                </tr>
            </table>

            <!-- PRICING TABLE -->
            <table class="table">
                <tr>
                    <th>Solution Description</th>
                    <th>Quantity</th>
                    <th>Per Service Total</th>
                    <th>Annual Total</th>
                </tr>
                <tr>
                    <td>GermBlast Service</td>
                    <td>3</td>
                    <td>$28,825.58</td>
                    <td>$86,476.74</td>
                </tr>
                <tr>
                    <td>Discount 7.50%</td>
                    <td></td>
                    <td>$2,161.92</td>
                    <td>$6,485.76</td>
                </tr>
                <tr>
                    <td><strong>Total</strong></td>
                    <td></td>
                    <td><strong>$26,663.66</strong></td>
                    <td><strong>$79,990.98</strong></td>
                </tr>
            </table>

            <!-- SERVICE OUTLINE -->
            <h4 style="margin-top:16pt;">GermBlast Service Outline</h4>

            <table style="width:100%; font-size:10pt;">
                <tr>
                    <td style="width:33%; vertical-align:top;">
                        • High School<br>
                        • Paul Belton Elementary School<br>
                        • High School Athletic Equipment<br>
                        • Buses
                    </td>
                    <td style="width:33%; vertical-align:top;">
                        • Middle School<br>
                        • Bulldog Academy<br>
                        • Middle School Athletics
                    </td>
                    <td style="width:33%; vertical-align:top;">
                        • Crockett & Gateway Elementary School<br>
                        • High School Athletics<br>
                        • Middle School Athletic Equipment
                    </td>
                </tr>
            </table>

            <hr>

            <!-- NOTE -->
            <p style="font-size:10pt; margin-top:14pt;">
                <em>
                    Please be advised. Beginning September 1, 2023, a 3% fee will be added to all credit card payments
                    greater than $10,000.00.
                </em>
            </p>

            <!-- SIGNATURES -->
            <table style="width:100%; font-size:10pt; margin-top:18pt;">
                <tr>
                    <td style="width:25%;">Quote Prepared By:</td>
                    <td style="width:75%;">Heath Herrington 11/11/25</td>
                </tr>
                <tr>
                    <td style="padding-top:10pt;">To Approve, Sign and Return:</td>
                    <td style="padding-top:10pt;">__________________________________________</td>
                </tr>
                <tr>
                    <td style="padding-top:10pt;">Date Signed (Effective Date):</td>
                    <td style="padding-top:10pt;">__________________________________________</td>
                </tr>
            </table>

        </div>

        <div class="footer">
            © {{ now()->year }} GermBlast. All Rights Reserved.
        </div>

    </div> --}}

    {{-- Page 5.2 --}}
    @foreach ($pricingDetails as $pricing)
        <div class="page">

            <div class="page-bg">
                <img src="{{ asset('img/survey-proposal/page5_img1.png') }}">
            </div>

            <div class="content">

                <h4>
                    GermBlast Proposal - {{ $pricing->proposal_name ?? '' }}
                </h4>

                <!-- COMPANY DETAILS -->
                <table style="width:100%; font-size:10pt; margin-bottom:12pt;">
                    <tr>
                        <td style="width:50%; vertical-align:top;">
                            <strong>Infection Controls, Inc.</strong><br>
                            1414 Avenue J<br>
                            Lubbock, TX 79401<br>
                            877.771.3558
                        </td>

                        <td style="width:50%; vertical-align:top;">
                            <strong>{{ $survey->company->name }}</strong><br>
                            {{ $survey->company->locations->first()->full_address ?? '' }}<br>
                            {{ $survey->company->companyPhone->phone ?? '' }}
                        </td>
                    </tr>
                </table>

                <!-- PROPOSAL META -->
                <table class="table" style="margin-bottom:14pt;">
                    <tr>
                        <th>Proposal ID</th>
                        <th>Services / Year</th>
                        <th>Contract Term</th>
                        <th>Payment Terms</th>
                    </tr>
                    <tr>
                        <td>{{ $pricing->id }}</td>
                        <td>{{ $pricing->services_per_year }}</td>
                        <td>{{ $pricing->contract_terms }} year(s)</td>
                        <td>Due on Receipt</td>
                    </tr>
                </table>

                @php
                    $basePrice = $pricing->override_pricing > 0 ? $pricing->override_pricing : $pricing->pricing_total;
                    $annualPrice = $basePrice * $pricing->services_per_year;
                    
                    $discountPercentage = $pricing->discounts ?? 0;
                    
                    $discountPerService = $basePrice * ($discountPercentage / 100);
                    $discountAnnual = $annualPrice * ($discountPercentage / 100);
                    
                    $finalPerService = $basePrice - $discountPerService;
                    $finalAnnual = $annualPrice - $discountAnnual;
                @endphp

                <!-- PRICING TABLE -->
                <table class="table">
                    <tr>
                        <th>Solution Description</th>
                        <th>Quantity</th>
                        <th>Per Service Total</th>
                        <th>Annual Total</th>
                    </tr>

                    <tr>
                        <td>Germblast Service</td>
                        <td>{{ $pricing->services_per_year }}</td>
                        <td>${{ number_format($basePrice, 2) }}</td>
                        <td>${{ number_format($annualPrice, 2) }}</td>
                    </tr>

                    @if($discountPercentage > 0)
                    <tr>
                        <td>Discount {{ number_format($discountPercentage, 2) }}%</td>
                        <td></td>
                        <td>-${{ number_format($discountPerService, 2) }}</td>
                        <td>-${{ number_format($discountAnnual, 2) }}</td>
                    </tr>
                    @endif

                    <tr>
                        <td><strong>Total</strong></td>
                        <td></td>
                        <td><strong>${{ number_format($finalPerService, 2) }}</strong></td>
                        <td><strong>${{ number_format($finalAnnual, 2) }}</strong></td>
                    </tr>
                </table>

                <!-- SERVICE OUTLINE -->
                <h4 style="margin-top:16pt;">Germblast Service Outline</h4>

                @php
                    // Take only first 9 services (3 columns × 3 rows)
                    $services = $pricing->pricingServices->take(9);

                    // Split into columns of 3 items
                    $columns = $services->chunk(3);
                @endphp

                <table style="width:100%; font-size:10pt;">
                    <tr>
                        @for ($i = 0; $i < 3; $i++)
                            <td style="width:33%; vertical-align:top;">
                                @if (isset($columns[$i]))
                                    @foreach ($columns[$i] as $service)
                                        • {{ $service->service_name }}<br>
                                    @endforeach
                                @endif
                            </td>
                        @endfor
                    </tr>
                </table>

                <hr>

                <!-- NOTE -->
                <p style="font-size:10pt; margin-top:14pt;">
                    <em>
                        Please be advised. Beginning September 1, 2023, a 3% fee will be added to all credit card
                        payments
                        greater than $10,000.00.
                    </em>
                </p>

                <!-- SIGNATURES -->
                <table style="width:100%; font-size:10pt; margin-top:18pt;">
                    <tr>
                        <td style="width:25%;">Quote Prepared By:</td>
                        <td style="width:75%;">{{ $survey->user->name }}  {{ now()->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <td style="padding-top:10pt;">To Approve, Sign and Return:</td>
                        <td style="padding-top:10pt;">__________________________________________</td>
                    </tr>
                    <tr>
                        <td style="padding-top:10pt;">Date Signed (Effective Date):</td>
                        <td style="padding-top:10pt;">__________________________________________</td>
                    </tr>
                </table>

            </div>

            <div class="footer">
                © {{ now()->year }} GermBlast. All Rights Reserved.
            </div>

        </div>

        @if (!$loop->last)
            <div style="page-break-after: always;"></div>
        @endif
    @endforeach


    <!-- ================= PAGE 4 ================= -->
    <div class="page">

        <div class="page-bg">
            <img src="{{ asset('img/survey-proposal/page4_img1.png') }}">
        </div>

        <div class="content">

            <h4>GermBlast Service - Available Applications</h4>

            <h4>GermBlast Service - Description</h4>

            <h4>GermBlast Pretreatment</h4>
            <p>
                Before a surface can be disinfected, it must first be cleaned. GermBlast staff utilize disposable,
                antimicrobial microfiber
                cloths in conjunction with a pretreatment chemical, Oxivir Five 16 or Opti-cide 3. GermBlast
                Pretreatment
                breaks
                through biofilm allowing for a more efficient sanitizing and disinfecting step.
            </p>

            <h4>GermBlast Spray</h4>
            <p>
                GermBlast Spray utilizes a rapid kill surface disinfectant. This powerful, hospital-grade disinfectant
                kills 99.999% of
                detectable pathogens. State of the art spraying systems help technicians achieve an efficient coverage.
                This GermBlast
                Spray modality is non-corrosive, non-toxic, and non-staining.
            </p>

            <h4>GermBlast Steam</h4>
            <p>
                GermBlast Steam offers a unique solution that allows an extremely high level of cleanliness while
                disinfecting the
                establishment, the dual purpose cleaning makes the process much more effective. A diverse assortment of
                pathogenic
                microorganisms can be rapidly killed by GermBlast Steam within 5 seconds. Risks of infection from
                contaminated
                surfaces will decrease further with more frequent treatments.
            </p>

            <h4>GermBlast PCO (Photocatalytic Oxidation)</h4>
            <p>
                GermBlast UV-PCO is one of the most effective air purification devices. It is capable of disinfecting
                over
                60 harmful
                airborne pathogens including norovirus, tuberculosis, pneumonia, and influenza virus. UV-PCO creates a
                reaction
                between ultraviolet light and a titanium dioxide based catalyst in the presence of water that oxidizes
                and eliminates
                microorganisms circulating in the air.
            </p>

            <h4>GermBlast H2O2</h4>
            <p>
                GermBlast Dry Mist H2O2 utilizes a hydrogen peroxide and silver based disinfectant to eliminate the most
                robust
                microorganisms in an environment. This modality utilizes dry mist technology to atomize the disinfectant
                and distribute
                it throughout the environment ensuring complete coverage of an area from ceiling to floor. GermBlast
                H2O2 will not
                damage electronics or surfaces and breaks down into oxygen and water without leaving a residue.
            </p>

            <h4>GermBlast Shield</h4>
            <p>
                GermBlast Shield employs an innovative polymer that adheres to surfaces and inhibits odor-causing
                microorganism
                colonization, yet is safe to touch. The polymer is applied using electrostatic spraying technology that
                ensure 100%
                coverage by negatively charging chemicals, causing them to completely and efficiently cover every
                surface.
                Surface
                protection lasts for up to 90 days.
            </p>

        </div>

        <div class="footer">
            © {{ now()->year }} GermBlast. All Rights Reserved.
        </div>

    </div>

    <!-- ================= PAGE 6 ================= -->
    <div class="page">

        <div class="page-bg">
            <img src="{{ asset('img/survey-proposal/page4_img1.png') }}">
        </div>

        <div class="content">

            <h4>Contact Information</h4>

            <p>
                This section outlines the people who you would like GermBlast to contact regarding GermBlast service.
                Please complete and return to your GermBlast Sales Representative.
            </p>

            <p><strong>Scheduling Contact:</strong> GermBlast Service Staff will contact this person to coordinate
                scheduling dates</p>

            <table style="width:100%; font-size:10pt; margin-top:10pt;">
                <tr>
                    <td style="width:20%;">Name</td>
                    <td style="width:80%;">_______________________________________________</td>
                </tr>
                <tr>
                    <td style="padding-top:8pt;">Title</td>
                    <td style="padding-top:8pt;">_______________________________________________</td>
                </tr>
                <tr>
                    <td style="padding-top:8pt;">Phone Number</td>
                    <td style="padding-top:8pt;">_______________________________________________</td>
                </tr>
            </table>

            <p style="margin-top:18pt;">
                <strong>Service Contact:</strong> GermBlast Service Staff will contact this person when our team arrives
                to
                perform service to help coordinate facility access.
            </p>

            <table style="width:100%; font-size:10pt; margin-top:10pt;">
                <tr>
                    <td style="width:20%;">Name</td>
                    <td style="width:80%;">_______________________________________________</td>
                </tr>
                <tr>
                    <td style="padding-top:8pt;">Title</td>
                    <td style="padding-top:8pt;">_______________________________________________</td>
                </tr>
                <tr>
                    <td style="padding-top:8pt;">Phone Number</td>
                    <td style="padding-top:8pt;">_______________________________________________</td>
                </tr>
            </table>

            <p style="margin-top:18pt;"><strong>Billing Contact</strong></p>

            <table style="width:100%; font-size:10pt; margin-top:10pt;">
                <tr>
                    <td style="width:20%;">Name</td>
                    <td style="width:80%;">_______________________________________________</td>
                </tr>
                <tr>
                    <td style="padding-top:8pt;">Title</td>
                    <td style="padding-top:8pt;">_______________________________________________</td>
                </tr>
                <tr>
                    <td style="padding-top:8pt;">Phone Number</td>
                    <td style="padding-top:8pt;">_______________________________________________</td>
                </tr>
                <tr>
                    <td style="padding-top:8pt;">Email</td>
                    <td style="padding-top:8pt;">_______________________________________________</td>
                </tr>
            </table>

        </div>

        <div class="footer">
            © {{ now()->year }} GermBlast. All Rights Reserved.
        </div>

    </div>

    <!-- ================= PAGE 7 ================= -->
    <div class="page">

        <div class="page-bg">
            <img src="{{ asset('img/survey-proposal/page4_img1.png') }}">
        </div>

        <div class="content">

            <h4>Group Purchasing Cooperatives</h4>

            <p>
                Sign and Date next to the Contract that you would like to utilize for this proposal.
                Return this sheet with your signed proposal pages.
            </p>

            <table style="width:100%; font-size:10pt; margin-top:16pt;">
                <tr>
                    <td style="width:55%; vertical-align:top;">
                        <strong>230103</strong><br>
                        Janitorial and Sanitation Supplies and Services
                    </td>
                    <td style="width:45%; vertical-align:top;">
                        ___________________________________________<br>
                        <span style="font-size:9pt;">Signature</span>
                        <span style="float:right; font-size:9pt;">Date</span>
                    </td>
                </tr>
            </table>

            <table style="width:100%; font-size:10pt; margin-top:16pt;">
                <tr>
                    <td style="width:55%; vertical-align:top;">
                        <strong>230603</strong><br>
                        Pathogen Removal and Remediation Supplies and Services (Includes PPE,
                        Sanitizers, Pathogen Barriers, and Disinfectants)
                    </td>
                    <td style="width:45%; vertical-align:top;">
                        ___________________________________________<br>
                        <span style="font-size:9pt;">Signature</span>
                        <span style="float:right; font-size:9pt;">Date</span>
                    </td>
                </tr>
            </table>

            <table style="width:100%; font-size:10pt; margin-top:16pt;">
                <tr>
                    <td style="width:55%; vertical-align:top;">
                        <strong>230701</strong><br>
                        Indoor Air Quality Equipment and Services
                    </td>
                    <td style="width:45%; vertical-align:top;">
                        ___________________________________________<br>
                        <span style="font-size:9pt;">Signature</span>
                        <span style="float:right; font-size:9pt;">Date</span>
                    </td>
                </tr>
            </table>

            <table style="width:100%; font-size:10pt; margin-top:16pt;">
                <tr>
                    <td style="width:55%; vertical-align:top;">
                        <strong>230903</strong><br>
                        Industrial and Facility Equipment, Chemicals, Supplies, and Services
                    </td>
                    <td style="width:45%; vertical-align:top;">
                        ___________________________________________<br>
                        <span style="font-size:9pt;">Signature</span>
                        <span style="float:right; font-size:9pt;">Date</span>
                    </td>
                </tr>
            </table>

            <table style="width:100%; font-size:10pt; margin-top:16pt;">
                <tr>
                    <td style="width:55%; vertical-align:top;">
                        <strong>240102</strong><br>
                        Emergency Responder Supplies, Equipment, and Services
                    </td>
                    <td style="width:45%; vertical-align:top;">
                        ___________________________________________<br>
                        <span style="font-size:9pt;">Signature</span>
                        <span style="float:right; font-size:9pt;">Date</span>
                    </td>
                </tr>
            </table>

            <table style="width:100%; font-size:10pt; margin-top:20pt;">
                <tr>
                    <td style="width:55%; vertical-align:top;">
                        <strong>22-7434</strong><br>
                        Maintenance, Repair and Operation (MRO) Equipment, Supplies, Materials
                        and Services
                    </td>
                    <td style="width:45%; vertical-align:top;">
                        ___________________________________________<br>
                        <span style="font-size:9pt;">Signature</span>
                        <span style="float:right; font-size:9pt;">Date</span>
                    </td>
                </tr>
            </table>

        </div>


        <div class="footer">
            © {{ now()->year }} GermBlast. All Rights Reserved.
        </div>

    </div>

    <!-- ================= PAGE 8 ================= -->
    <div class="page">

        <div class="page-bg">
            <img src="{{ asset('img/survey-proposal/page4_img1.png') }}">
        </div>

        <div class="content">

            <h4>Group Purchasing Cooperatives (Continued)</h4>

            <p>
                Sign and Date next to the Contract that you would like to utilize for this proposal.
                Return this sheet with your signed proposal pages.
            </p>

            <!-- REGION 5 -->
            <table style="width:100%; font-size:10pt; margin-top:18pt;">
                <tr>
                    <td style="width:55%; vertical-align:top;">
                        <strong>20240705</strong><br>
                        Janitorial Equipment, Parts and/or Services
                    </td>
                    <td style="width:45%; vertical-align:top;">
                        ___________________________________________<br>
                        <span style="font-size:9pt;">Signature</span>
                        <span style="float:right; font-size:9pt;">Date</span>
                    </td>
                </tr>
            </table>

            <!-- TEXBUY -->
            <table style="width:100%; font-size:10pt; margin-top:20pt;">
                <tr>
                    <td style="width:55%; vertical-align:top;">
                        <strong>RFP #023-086</strong><br>
                        Job Order Contracting
                    </td>
                    <td style="width:45%; vertical-align:top;">
                        ___________________________________________<br>
                        <span style="font-size:9pt;">Signature</span>
                        <span style="float:right; font-size:9pt;">Date</span>
                    </td>
                </tr>
            </table>

            <table style="width:100%; font-size:10pt; margin-top:18pt;">
                <tr>
                    <td style="width:55%; vertical-align:top;">
                        <strong>RFP #024-050</strong><br>
                        Restoration and Sanitization Services
                    </td>
                    <td style="width:45%; vertical-align:top;">
                        ___________________________________________<br>
                        <span style="font-size:9pt;">Signature</span>
                        <span style="float:right; font-size:9pt;">Date</span>
                    </td>
                </tr>
            </table>

            <!-- REGION 7 -->
            <table style="width:100%; font-size:10pt; margin-top:20pt;">
                <tr>
                    <td style="width:55%; vertical-align:top;">
                        <strong>CONSRV2426</strong><br>
                        Contracted Services
                    </td>
                    <td style="width:45%; vertical-align:top;">
                        ___________________________________________<br>
                        <span style="font-size:9pt;">Signature</span>
                        <span style="float:right; font-size:9pt;">Date</span>
                    </td>
                </tr>
            </table>

        </div>


        <div class="footer">
            © {{ now()->year }} GermBlast. All Rights Reserved.
        </div>

    </div>

    <!-- ================= PAGE 9 ================= -->
    <div class="page">

        <div class="page-bg">
            <img src="{{ asset('img/survey-proposal/page4_img1.png') }}">
        </div>

        <div class="content" style="font-size:11pt;">

            <p>
                <strong>
                    The above pricing is based on a committed contract performing GermBlast services in areas outlined
                    in
                    the Service Outline section of the above pricing sheet.
                </strong>
                By signing you agree to have GermBlast performed at Borger ISD at dates and times to be mutually
                determined
                based on the service schedule above.
            </p>

            <p>
                <em>
                    This proposal includes data that shall not be disclosed outside of Borger ISD or the Government and
                    shall not be duplicated, used, or disclosed—in whole or in part—for any purpose other than to
                    evaluate
                    this proposal.
                </em>
                The data subject to this restriction is defined as this proposal and other documentation provided in
                preparation of this proposal. Likewise, all information collected for the purposes of this proposal,
                including ATP samples, shall remain confidential between Borger ISD and GermBlast regardless of the
                disposition of a contract between the two parties.
            </p>

            <p style="font-weight:bold; margin-top:16pt;">
                Limited Warranty and Liability
            </p>

            <p style="font-size:9.5pt; line-height:1.4;">
                GERMBLAST WARRANTS THAT UPON COMPLETION OF ITS GERMBLAST™ TREATMENT FOR CUSTOMER (MANAGING BIOBURDEN AND
                KILLING MICROORGANISMS) MICROORGANISMS WILL THEN EXIST IN ACCEPTABLE LEVELS AS DETERMINED BY GERMBLAST,
                IN ITS
                SOLE OPINION AND DISCRETION. HOWEVER, GERMBLAST DOES NOT WARRANT AND EXPRESSLY DENIES AND EXCLUDES, ANY
                AND
                ALL OTHER EXPRESSED OR IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE,
                INCLUDING, BUT NOT LIMITED TO, THE REINTRODUCTION OF SUCH MICROORGANISMS AFTER COMPLETION OF ITS
                GERMBLAST
                TREATMENT. GERMBLAST SOLE OBLIGATION UNDER THIS WARRANTY AND THE CUSTOMER’S EXCLUSIVE REMEDY IS LIMITED
                TO NO
                MORE THAN ONE OTHER TREATMENT, WITHOUT COST TO CUSTOMER, IF GERMBLAST DETERMINES, AT ITS SOLE
                DISCRETION,
                THAT ITS PRIOR TREATMENT FOR CUSTOMER WAS DEFECTIVE, PROVIDED CUSTOMER IMMEDIATELY, UPON DISCOVERY OF
                ANY
                TREATMENT FAILURE, NOTIFIES GERMBLAST OF ANY SUCH CLAIMED DEFECT OR FAILURE AND IS ALLOWED TO INSPECT
                THE
                TREATED PREMISES AND REVIEW ANY OBJECTIVE EVIDENCE UPON REQUEST.
            </p>

            <p style="font-size:9.5pt; line-height:1.4;">
                CUSTOMER AGREES THAT GERMBLAST, AND ANY OF ITS OWNERS, EMPLOYEES, OFFICERS, AGENTS, OR ASSIGNS, WILL NOT
                BE
                SUBJECT TO ANY OTHER OR FURTHER LIABILITY OF ANY KIND, INCLUDING, BUT NOT LIMITED TO, ANY ACTUAL,
                INCIDENTAL, OR CONSEQUENTIAL DAMAGES RESULTING FROM ANY BREACH OF WARRANTY EXCEPT AS EXPRESSLY PROVIDED
                HEREIN.
            </p>

            <p style="font-size:9.5pt; line-height:1.4;">
                THIS WARRANTY IS MADE IN LIEU OF ALL OTHER WARRANTIES, EXPRESS OR IMPLIED, INCLUDING MERCHANTABILITY AND
                FITNESS FOR A PARTICULAR PURPOSE. THERE ARE NO WARRANTIES WHICH EXTEND BEYOND THE DESCRIPTION OF THE
                FACE
                HEREOF.
            </p>

            <p style="font-size:9.5pt; line-height:1.4;">
                CUSTOMER SHALL SAVE AND HOLD GERMBLAST, ITS OWNERS, EMPLOYEES, OFFICERS, AGENTS, AND ASSIGNS, WHOLE AND
                HARMLESS FROM AND AGAINST ANY AND ALL CLAIMS, COSTS, FEES, AND DAMAGES OF ANY KIND INCURRED OR IMPOSED
                AGAINST GERMBLAST, OR ANY OF ITS OWNERS, EMPLOYEES, OFFICERS, AGENTS, AND ASSIGNS, AS A RESULT OF ANY
                AND ALL
                CLAIMS MADE BY CUSTOMER, OR CUSTOMER’S OWNERS, EMPLOYEES, OFFICERS, AGENTS, ASSIGNS, GUESTS, INVITEES,
                OR
                OTHER ASSOCIATED THIRD-PARTIES OF CUSTOMER, FOR ANY CLAIMS ARISING UNDER THE LAW, INCLUDING, BUT NOT
                LIMITED TO, TORT, CONTRACT, BREACH OF WARRANTIES, AND DEFECTIVE SERVICES AND/OR PRODUCTS.
            </p>

        </div>



        <div class="footer">
            © {{ now()->year }} GermBlast. All Rights Reserved.
        </div>

    </div>

    <!-- ================= PAGE 10 ================= -->
    <div class="page">

        <div class="page-bg">
            <img src="{{ asset('img/survey-proposal/page4_img1.png') }}">
        </div>

        <div class="content" style="font-size:11pt;">

            <!-- ADDED VALUE -->
            <p style="font-weight:bold; margin-bottom:6pt;">Added Value</p>

            <p>
                With approval, GermBlast will put small stickers on your entry and exit doors that state,
                “Protected by, GermBlast (with logo)” and have our web address. In addition, GermBlast also
                has available flyers (announcing partnership) and unframed posters to further educate
                patients, staff and family members.
            </p>

            <hr style="border:none; border-top:1px solid #777; margin:16pt 0;">

            <!-- GB FLOORING -->
            <p style="color:#cc0000; font-weight:bold; font-size:14pt; margin-bottom:6pt;">
                GB Flooring
            </p>

            <p style="color:#cc0000; font-weight:bold;">
                GermBlast now provides an innovative strip and wax flooring program that will save your
                district time and money. Please contact your representative, Heath Herrington, for
                additional information (877) 771-3558.
            </p>

            <hr style="border:none; border-top:1px solid #777; margin:18pt 0;">

            <!-- CONFIDENTIALITY / VALIDITY -->
            <p style="font-weight:bold; text-transform:uppercase;">
                All information obtained for this survey is kept confidential and is only used for the
                sole purpose of providing a proposal. Proposal prices and discounts are valid for a
                maximum of 60 days and can be subject to change thereafter.
            </p>

            <!-- TEXAS GOVERNMENT CODE -->
            <p style="font-size:10pt; margin-top:18pt;">
                Pursuant to Texas Government Code Chapter 2270, Germblast represents and warrants that it
                does not boycott Israel and will not boycott Israel during the term of this Agreement.
            </p>

        </div>

        <div class="footer">
            © {{ now()->year }} GermBlast. All Rights Reserved.
        </div>

    </div>

    <!-- ================= PAGE 11 ================= -->
    <div class="page">

        <div class="content" style="top:60pt; font-size:10pt;">

            <h4 style="margin-bottom:4pt;">Texas Sales and Use Tax Exemption Certification</h4>
            <p style="font-size:9pt; margin-bottom:12pt;">
                This certificate does not require a number to be valid.
            </p>

            <!-- TOP INFO -->
            <table style="width:100%; border:1px solid #000; font-size:9pt; margin-bottom:10pt;">
                <tr>
                    <td style="padding:6pt;">
                        Name of purchaser, firm or agency
                    </td>
                </tr>
                <tr>
                    <td style="padding:6pt;">
                        Address (Street & number, P.O. Box or Route number)
                        <span style="float:right;">Phone (Area code and number)</span>
                    </td>
                </tr>
                <tr>
                    <td style="padding:6pt;">
                        City, State, ZIP code
                    </td>
                </tr>
            </table>

            <!-- CLAIM SECTION -->
            <table style="width:100%; border:1px solid #000; font-size:9pt; margin-bottom:10pt;">
                <tr>
                    <td style="padding:6pt;">
                        I, the purchaser named above, claim an exemption from payment of sales and use taxes
                        (for the purchase of taxable items described below or on the attached order or invoice) from:
                    </td>
                </tr>
                <tr>
                    <td style="padding:6pt;">
                        Seller: _______________________________________________
                    </td>
                </tr>
                <tr>
                    <td style="padding:6pt;">
                        Street address: ________________________________
                        <span style="float:right;">City, State, ZIP code: ________________________________</span>
                    </td>
                </tr>
                <tr>
                    <td style="padding:6pt;">
                        Description of items to be purchased or on the attached order or invoice:
                    </td>
                </tr>
                <tr>
                    <td style="padding:6pt;">
                        _______________________________________________<br>
                        _______________________________________________<br>
                        _______________________________________________<br>
                        _______________________________________________
                    </td>
                </tr>
                <tr>
                    <td style="padding:6pt;">
                        Purchaser claims this exemption for the following reason:
                    </td>
                </tr>
                <tr>
                    <td style="padding:6pt;">
                        _______________________________________________<br>
                        _______________________________________________<br>
                        _______________________________________________
                    </td>
                </tr>
            </table>

            <!-- LEGAL TEXT -->
            <p style="font-size:8.5pt; line-height:1.4;">
                I understand that I will be liable for payment of all state and local sales or use taxes which may
                become
                due for failure to comply with the provisions of the Tax Code and/or all applicable law.
            </p>

            <p style="font-size:8.5pt; line-height:1.4;">
                I understand that this is a criminal offense to give an exemption certificate to the seller for taxable
                items that I know, at the time of purchase, will be used in a manner other than that expressed in this
                certificate, and depending on the amount of tax evaded, the offense may range from a Class C misdemeanor
                to a felony of the second degree.
            </p>

            <!-- SIGNATURE -->
            <table style="width:100%; font-size:9pt; margin-top:12pt;">
                <tr>
                    <td style="width:33%;">
                        Signature ____________________________
                    </td>
                    <td style="width:33%;">
                        Title ____________________________
                    </td>
                    <td style="width:33%;">
                        Date ____________________________
                    </td>
                </tr>
            </table>

            <!-- NOTES -->
            <p style="font-size:8pt; margin-top:10pt;">
                <strong>NOTE:</strong> This certificate cannot be issued for the purchase, lease, or rental of a motor
                vehicle.
            </p>

            <p style="font-size:8pt;">
                <strong>THIS CERTIFICATE DOES NOT REQUIRE A NUMBER TO BE VALID.</strong><br>
                Sales and Use Tax “Exemption Numbers” or “Tax Exempt” Numbers do not exist.
            </p>

            <table style="width:100%; border:1px solid #000; margin-top:10pt;">
                <tr>
                    <td style="padding:6pt; font-size:8.5pt; text-align:center;">
                        This certificate should be furnished to the supplier.<br>
                        <strong>Do not send the completed certificate to the Comptroller of Public Accounts.</strong>
                    </td>
                </tr>
            </table>

        </div>

        <div class="footer">
            © {{ now()->year }} GermBlast. All Rights Reserved.
        </div>

    </div>

</body>

</html>
