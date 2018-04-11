setwd() #A compléter

#Doit changer selon les données entrées
myClass1 = "BK"
myClass2 = "INF"
myClass3 = "NONINF"
myClass4 = "GENTA"
myClass5 = "TWEEN"

#A modifier
myResultDir = "myAlign"

library(xcms)

xset <- xcmsSet(method='centWave', ppm=10,mzdiff=0.001,mzCenterFun="wMean",snthresh=5,prefilter=c(3,100), noise=0,peakwidth=c(20,120),integrate=1,fitgauss=F,verbose.columns=T)

xset
xset <- group(xset)
xset2 <- retcor(xset, family="s", plottype = "m")
xset2
xset2 <- group(xset2, bw =5)   
xset3 <- fillPeaks(xset2)
xset3
reporttab <- diffreport(xset3, myClass2, myClass3, myResultDir, 10, metlin = .003)
