<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        .outer-border{
            width:600px; height:850px; padding:20px; text-align:center; border: 30px solid #69b85b;
        }

        .inner-dotted-border{
            width:550px; height:800px; padding:20px; text-align:center; border: 5px solid #69b85b;
        }


        .certification{
            font-size:50px; font-weight:bold;    color: #663ab7;
        }

        .certify{
            font-size:25px;
        }

        .name{
            font-size:30px;    color: green;
        }

        .fs-30{
            font-size:30px;
        }

        .fs-20{
            font-size:20px;
        }

    </style>
    <title>Sertifika</title>
</head>
<body>

<div class="outer-border" >

    <div class="inner-dotted-border">
        <div class="d-flex justify-content-between">
            <div style="text-align: left;">
                <img src="{{ $logoPath }}" style="margin-bottom: 68px;" width="100" height="90" alt="Site Logo" class="logo_sticky">
            </div>
            <div style="text-align: right;">
                <div style="margin-top: -210px; margin-right: -50px;">
                    <img src="{{ $logo }}" width="180" height="210" alt="Site Logo" class="logo_sticky">
                </div>
            </div>
        </div>
        <div style="margin-top: -30px;">
            <span style="color: #428bca" class="certification">Tebrikler</span>
            <br>
            <span style="color: #0b0b0b" class="name"><b>{{$UserName}}</b></span><br/><br/>
            <span style="color: #428bca" class="name"><b>Karbon Ayak İziniz</b></span><br/><br/>
            <span style="color: #0b0b0b" class="name"><b>{{$total}} KG</b></span><br/><br/>
            <span class="" style="font-size: 23px;"><i>Bu sertifika, çevreye olan duyarlılığınızı ve karbon ayak izinizi azaltma çabanızı gösteren bir sembol olarak sunulmaktadır. Çevresel farkındalığınızı ve sorumluluğunuzu gösterdiğiniz için sizi Tebrik ederiz.</i></span>
            </i></span> <br/><br/>
            <span class="" style="font-size: 17px;"><i>Bu sertifika, Karbonayakizihesapla.com.tr sitesinde yapılan bir test sonucuna dayalı olarak alınmıştır.<br/></i></span>
            </i></span> <br/>
            <span class="certify"><i>Tarih</i></span><br>

            <span class="fs-30">{{\Carbon\Carbon::parse($created_at)->format('d.m.Y')}}</span>
        </div>
    </div>
</div>
</body>
</html>
