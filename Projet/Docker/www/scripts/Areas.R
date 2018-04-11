myAlign = read.table("myAlign.tsv",header=T,sep="\t")

#Extraction des noms des colonnes contenant les aires:
columns = grep("^X[0-9]+",colnames(myAlign),value=T)

#Création d'un nouveau tableau avec les valeurs d'intérêt:
areas = subset(myAlign,select=columns)

#Suppression des ions présents dans les conditions optionnelles :
for (i in c(1,2)){
  for(j in 3:ncol(areas)){
    areas = subset(areas, areas[,i]!=areas[,j])
  }
}

#EPS
setEPS()
postscript("Areas.eps")
plot(areas[,2],areas[,3], main="Graph area/area",pch=20,xlab=columns[1],ylab=columns[2])
abline(0,1)
dev.off()

