setwd("/home/coralie/Bureau/Docker/dockerfiles/www/data/tsv")

## Chargement des résultats du peak-picking:
myAlign = read.table("myAlign.tsv",header=T,sep="\t")

## Extraction des aires:
# Nom des colonnes contenant les aires:
columns = grep("^X[0-9]+",colnames(myAlign),value=T) 
# Extraction de ces colonnes dans un nouveau tableau:
areas = subset(myAlign,select=columns)

## Calcul du nombre de réplicats:
# Extraction des noms des colonnes correspondant aux noms des conditions:
cond = grep("^X[0-9]+|X|name|fold|tstat|pvalue|anova|mz[a-z]+|rt[a-z]+|npeaks|metlin",colnames(myAlign),value=T,invert=T)
# Nb réplicats = Nb de colonnes contenant des aires / nb de conditions:
nb_replicat = length(columns)/length(cond)

## Création du tableau de résultats:
# Nombre de tests à réaliser (= nb de colonnes du tableau de résultat):
nb_tests = (length(cond)*(length(cond)-1))/2
# Nouveau dataframe:
Results = data.frame(matrix(vector(),nrow(areas),nb_tests+1))
# Noms des colonnes du dataframe:
for(i in 2:(nb_tests+1)){
  names(Results)[i]=paste(cond[i-1],cond[i],sep="/")
}
# Première colonne (foldchange):
names(Results)[1] = "fold-change"
Results[,1] = subset(myAlign,select=grep("fold",colnames(myAlign),value=T))

## Calcul des p-values et stockage dans le tableau de résultats:
for (i in 1:nrow(areas)){ #Pour chaque ion
  cptr = 1
  col = 1 
  while (cptr<ncol(areas)-nb_replicat){
    cond1 = c(areas[i,cptr])
    for(m in (cptr+1):(cptr+nb_replicat-1)){
      cond1[length(cond1)+1] = areas[i,m]
    }
    cptr2 = cptr+nb_replicat
    col = col+1
    while(cptr2<ncol(areas)-1){
      cond2 = c(areas[i,cptr2])
      for(m in (cptr2+1):(cptr2+nb_replicat-1)){
        cond2[length(cond2)+1] = areas[i,m] 
      }
      Results[i,col] = t.test(cond1,cond2)$p.value #Test de Student entre les 2 conditions
      cptr2 = cptr2+3
    }
    cptr = cptr+3
    col = col+1
  }
}

##Export des données sous format CSV:
setwd("~/Bureau/Cours_Coralie/Ptut/Projet/Docker/www/data/csv")
write.table(Results, "Results.csv", row.names=FALSE, sep="\t",dec=",", na=" ")

## Graphe EPS
#setEPS()
#postscript("Volcano.eps")
#plot(-log10(Results[,2]),log2(Results[,1]),xlab="-log10 p-value", ylab="log2 foldchange")
#dev.off()





